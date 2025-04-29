$(function () {
    //buttons
    let callBtn = $("#callBtn");
    let acceptBtn = $("#acceptBtn");
    let declineBtn = $("#declineBtn");
    //variables
    let user = {};
    let receiverID = callBtn.data('user');
    let peerConnection;
    let localStream;

    const localVideo = document.querySelector('#localVideo');
    const remoteVideo = document.querySelector('#remoteVideo');

    function createConn() {
        if (!peerConnection) {
            peerConnection = new RTCPeerConnection();
        }
    }

    function showCall() {
        $("#profile-container").addClass('hidden');
        $("#profile-footer").addClass('hidden');
        $("#video-call-container").removeClass('hidden');
        $("#video-call-footer").removeClass('hidden');
    }

    async function getCam() {
        try {
            if (!peerConnection) {
                createConn();
            }

            let mediaStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            })

            localVideo.srcObject = mediaStream;
            localStream = mediaStream;
            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream))

            peerConnection.ontrack = (event) => {
                remoteVideo.srcObject = event.streams[0];
            }

        } catch (error) {
            console.error(error);
            if (error.name === 'PermissionDeniedError') {
                alert("Camera permission denied. Please allow access");
            } else if (error.name === 'NotFoundError') {
                alert("No Camera found. Please connect a camera and try again");
            } else {
                alert("Something went wrong: ", error.message);
            }
        }
    }

    callBtn.on('click', async () => {
        await getCam();
        getUser().then(function (data) {
            showCall();
            user = data
            send('is-client-ready', null, receiverID, user);
        }).catch(function (error) {
            console.error("Error getting user: ", error);
        });
    });

    function muteMic() {
        localVideo.srcObject.getAudioTracks().forEach(track => track.enabled = !track.enabled);
    }

    function muteCam() {
        localVideo.srcObject.getVideoTracks().forEach(track => track.enabled = !track.enabled);
    }

    $(document).on('click', '#muteCamBtn', () => {
        muteCam();
        $(this).toggleClass('text-red-400');
    });

    $(document).on('click', '#muteMicBtn', () => {
        muteMic();
        $(this).toggleClass('text-red-400');
    });

    $(document).on('click', '#hangupBtn', () => {
    });

    function getUser(id = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/getUser',
                type: 'GET',
                data: { id: id },
                success: function (response) {
                    resolve(response);
                },
                error: function (error) {
                    reject(error);
                }
            })
        })
    }

    function showHideCallPopup(name, image, text, btns = true) {
        $("#caller-popup-container").toggleClass('hidden');
        $("#caller-name").text(`${name} ${text}`);
        $("#caller-profileImage").attr('src', '/storage/' + image);
        if (btns === false) {
            $(".call-buttons").hide();
        }
    }

    function send(type, data, receiverID, user) {
        Echo.private(`chat.${receiverID}`).whisper('Webrtc', {
            senderID: user.id || null,
            senderName: user.name || null,
            profileImage: user.profileImage || null,
            recipientId: receiverID,
            type: type,
            data: data
        })
    }

    async function createOffer(receiverID, user) {
        await peerConnection.createOffer({
            OfferToReceiveVideo: 1,
            OfferToReceiveAudio: 0
        });
        await peerConnection.setLocalDescription(peerConnection.localDescription);
        send('client-offer', peerConnection.localDescription, receiverID, user);
        sendIceCandidate(receiverID);
    }

    async function createAnswer(receiverID, data) {
        if (!peerConnection) {
            await createConn();
        }

        if (!localStream) {
            await getCam();
        }

        await peerConnection.setRemoteDescription(data);
        await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(peerConnection.localDescription);
        send('client-answer', peerConnection.localDescription, receiverID, '');
        sendIceCandidate(receiverID);
    }

    async function sendIceCandidate(receiverID) {
        peerConnection.onicecandidate = event => {
            if (event.candidate !== null) {
                send('client-candidate', event.candidate, receiverID, '');
            }
        }

        peerConnection.onicecandidatestatechange = (event) => {
            if (peerConnection.iceConnectionState === 'disconnected' || peerConnection.iceConnectionState === 'failed') {
                alert("The other user has disconnected.");
                // setTimeout('window.location.reload(true)', 2000);
            }
        }
    }

    Echo.private(`chat.${authID}`).listenForWhisper('Webrtc', async (e) => {
        let message = e;
        console.log(message);
        let type = message.type;
        let data = message.data;
        let receiver = message.recipientId;

        let sender = {
            id: message.senderID,
            name: message.senderName,
            profileImage: message.profileImage
        };

        switch (type) {
            case 'client-candidate':
                if (peerConnection.localDescription) {
                    await peerConnection.addIceCandidate(new RTCIceCandidate(data));
                }
                break;
            case 'is-client-ready':
                if (!peerConnection) {
                    await createConn();
                }

                if (peerConnection.iceConnectionState === 'connected') {
                    getUser(receiver).then(function (data) {
                        user = data
                        // send('client-already-oncall', null, receiverID, data);
                    }).catch(function (error) {
                        localStream
                        console.error("Error getting user: ", error);
                    });
                } else {
                    showHideCallPopup(sender.name, sender.profileImage, 'is calling');

                    acceptBtn.on('click', function () {
                        getUser(receiver).then(function (data) {
                            showHideCallPopup(sender.name, sender.profileImage, '');
                            send('client-is-ready', null, sender.id, data);
                        }).catch(function (error) {
                            localStream
                            console.error("Error getting user: ", error);
                        });
                    });

                    declineBtn.on('click', function () {
                        getUser(receiver).then(function (data) {
                            send('client-rejected', null, sender.id, data);
                            location.reload(true);
                        }).catch(function (error) {
                            localStream
                            console.error("Error getting user: ", error);
                        });
                    });

                }
                break;
            case 'client-is-ready':
                createOffer(receiverID, user);
                break;
            case 'client-offer':
                createAnswer(sender.id, data);
                showCall();
                break;
            case 'client-answer':
                if (peerConnection.localDescription) {
                    await peerConnection.setRemoteDescription(data);
                }
                break;
            case 'client-already-oncall':
                showHideCallPopup(sender.name, sender.profileImage, 'is on another call');
                // setTimeout('window.location.reload(true)', 2000);
                break;
            case 'client-rejected':
                showHideCallPopup(sender.name, sender.profileImage, 'is busy');
                // setTimeout('window.location.reload(true)', 2000);
                break;
        }
    });

});
