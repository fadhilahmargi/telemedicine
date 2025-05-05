$(function () {
    // DOM Elements
    const callBtn = $("#callBtn");
    const acceptBtn = $("#acceptBtn");
    const declineBtn = $("#declineBtn");
    const hangupBtn = $("#hangupBtn");
    const muteMicBtn = $("#muteMicBtn");
    const muteCamBtn = $("#muteCamBtn");
    const addCameraBtn = $("#add-camera-btn");
    const startCallBtn = $("#start-call-btn");

    // candidate queue array
    const candidateQueue = [];

    // State variables
    let user = {};
    let receiverID = callBtn.data('user');
    let peerConnection = null;
    let localStreams = [];
    let remoteStreams = new Map(); // Use Map to track remote streams by ID
    let isCallActive = false;

    // WebRTC configuration
    const rtcConfig = {
        iceServers: [
            { urls: "stun:stun.l.google.com:19302" },
            // Add TURN server configuration for NAT traversal
            // { urls: "turn:your-turn-server", username: "username", credential: "password" }
        ],
        iceCandidatePoolSize: 10
    };

    /**
     * Create and initialize a new RTCPeerConnection
     * @returns {RTCPeerConnection} - The created peer connection
     */
    function createPeerConnection() {
        if (peerConnection) {
            cleanupPeerConnection();
        }

        peerConnection = new RTCPeerConnection(rtcConfig);

        // Handle ICE candidates
        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                sendSignal('client-candidate', event.candidate, receiverID);
            }
        };

        // Monitor ICE connection state
        peerConnection.oniceconnectionstatechange = () => {
            console.log(`ICE connection state: ${peerConnection.iceConnectionState}`);

            switch (peerConnection.iceConnectionState) {
                case 'disconnected':
                case 'failed':
                    showNotification("Connection lost. Attempting to reconnect...");
                    break;
                case 'closed':
                    showNotification("Call ended");
                    break;
                case 'connected':
                    showNotification("Connection established");
                    break;
            }
        };

        // Handle remote tracks
        getUser(receiverID).then(user => {
            peerConnection.ontrack = (event) => {
                handleRemoteTrack(event, user);
            };

            return peerConnection;
        });
    }

    /**
     * Handle incoming remote media tracks
     * @param {RTCTrackEvent} event - The track event
     */
    function handleRemoteTrack(event, user = null) {
        const stream = event.streams[0];

        if (!stream) {
            console.error("Received track without stream");
            return;
        }

        if (!remoteStreams.has(stream.id)) {
            remoteStreams.set(stream.id, stream);

            // Create container for this stream if it doesn't exist
            if (!$(`#remoteVideo-${stream.id}`).length) {
                // $("#remoteVideoContainer").append(`
                //     <div class="remote-video-wrapper">
                //         <video id="remoteVideo-${stream.id}" class="w-1/2 h-auto bg-black mb-2" autoplay></video>
                //         <div class="text-center text-[14px] text-black">${user.name}</div>
                //     </div>
                // `);
                $("#remoteVideoContainer").append(`
                    <div class="relative w-full h-[300px] bg-black rounded-lg overflow-hidden shadow-md">
                        <video id="remoteVideo-${stream.id}" class="w-full h-full object-cover rounded-lg" autoplay></video>
                        <div class="absolute bottom-2 left-2 bg-black text-white text-xs px-2 py-1 rounded opacity-80">
                            ${user.name}
                        </div>
                    </div>
                `);

                const videoElement = $(`#remoteVideo-${stream.id}`)[0];
                videoElement.srcObject = stream;

                // Handle errors in remote video playback
                videoElement.onerror = (error) => {
                    console.error(`Error with remote video: ${error}`);
                    showNotification("Error playing remote video");
                };
            }
        }
    }

    /**
     * Show a notification message to the user
     * @param {string} message - The message to display
     * @param {number} duration - Duration in ms (default: 3000)
     */
    function showNotification(message, duration = 3000) {
        // Check if notification container exists, create if not
        if (!$("#notification-container").length) {
            $("body").append(`
                <div id="notification-container" class="fixed top-4 right-4 z-50"></div>
            `);
        }

        const notificationId = Date.now();
        $("#notification-container").append(`
            <div id="notification-${notificationId}" class="bg-gray-800 text-white rounded-md p-3 mb-2 opacity-0 transition-opacity duration-300">
                ${escapeHtml(message)}
            </div>
        `);

        // Fade in and out
        setTimeout(() => $(`#notification-${notificationId}`).removeClass('opacity-0'), 10);
        setTimeout(() => {
            $(`#notification-${notificationId}`).addClass('opacity-0');
            setTimeout(() => $(`#notification-${notificationId}`).remove(), 300);
        }, duration);
    }

    /**
     * Sanitize HTML content
     * @param {string} text - Text to escape
     * @returns {string} - Escaped HTML
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Switch UI to call mode
     */
    function showCallInterface() {
        $("#profile-container").addClass('hidden');
        $("#profile-footer").addClass('hidden');
        $("#call-setup-container").addClass('hidden');
        $("#video-call-container").removeClass('hidden');
        $("#video-call-footer").removeClass('hidden');
    }

    /**
     * Show call popup for incoming calls
     * @param {string} name - Caller name
     * @param {string} image - Caller profile image
     * @param {string} text - Additional text
     * @param {boolean} showButtons - Whether to show accept/decline buttons
     */
    function showCallPopup(name, image, text, showButtons = true) {
        $("#caller-popup-container").removeClass('hidden');
        $("#caller-name").text(`${escapeHtml(name)} ${escapeHtml(text)}`);

        $(".call-buttons").toggle(showButtons);
    }

    /**
     * Hide call popup
     */
    function hideCallPopup() {
        $("#caller-popup-container").addClass('hidden');
    }

    /**
     * Get user information
     * @param {number|null} id - User ID (optional)
     * @returns {Promise<Object>} - User data
     */
    async function getUser(id = null) {
        try {
            const response = await $.ajax({
                url: '/getUser',
                type: 'GET',
                data: { id: id }
            });
            return response;
        } catch (error) {
            console.error("Error fetching user data:", error);
            showNotification("Failed to load user data");
            throw error;
        }
    }

    /**
     * Send WebRTC signaling message
     * @param {string} type - Message type
     * @param {*} data - Message data
     * @param {number} recipientId - Recipient ID
     * @param {Object|null} userData - Sender data
     */
    // function sendSignal(type, data, recipientId, userData = null) {
    //     try {
    //         console.log(`Sending ${type} to ${recipientId}`, data);
    //         Echo.private(`chat.${recipientId}`).whisper('Webrtc', {
    //             senderID: userData?.id || user.id || null,
    //             senderName: userData?.name || user.name || null,
    //             profileImage: userData?.profileImage || user.profileImage || null,
    //             recipientId: recipientId,
    //             type: type,
    //             data: data,
    //             timestamp: Date.now()
    //         });
    //     } catch (error) {
    //         console.error("Error sending signal:", error);
    //         showNotification("Failed to send signal");
    //     }
    // }

    function sendSignal(type, data, recipientId, userData = null) {
        try {
            logWithTimestamp(`Preparing to send ${type} to ${recipientId}`);

            // Check if connection is ready before sending
            if (Echo.connector.pusher.connection.state !== 'connected') {
                logWithTimestamp(`WARNING: Connection state is ${Echo.connector.pusher.connection.state}, waiting for reconnection...`);

                // Set up a temporary listener to send after reconnection
                const tempListener = () => {
                    logWithTimestamp(`Connection restored, now sending delayed ${type}`);
                    sendActualSignal();
                    Echo.connector.pusher.connection.unbind('connected', tempListener);
                };

                Echo.connector.pusher.connection.bind('connected', tempListener);

                // Also set a timeout in case reconnection takes too long
                setTimeout(() => {
                    logWithTimestamp(`Timeout waiting for reconnection, attempting to send ${type} anyway`);
                    Echo.connector.pusher.connection.unbind('connected', tempListener);
                    sendActualSignal();
                }, 5000);

                return;
            }

            // If connection is good, send immediately
            sendActualSignal();

            function sendActualSignal() {
                logWithTimestamp(`Actually sending ${type} to ${recipientId}`);
                Echo.private(`chat.${recipientId}`).whisper('Webrtc', {
                    senderID: userData?.id || user.id || null,
                    senderName: userData?.name || user.name || null,
                    profileImage: userData?.profileImage || user.profileImage || null,
                    recipientId: recipientId,
                    type: type,
                    data: data,
                    timestamp: Date.now()
                });
                logWithTimestamp(`${type} whisper sent`);
            }
        } catch (error) {
            console.error("Error sending signal:", error);
            showNotification("Failed to send signal");
        }
    }

    /**
     * Clean up peer connection and media resources
     */
    function cleanupPeerConnection() {
        if (peerConnection) {
            // Stop all senders
            peerConnection.getSenders().forEach(sender => {
                if (sender.track) {
                    sender.track.stop();
                }
            });

            peerConnection.close();
            peerConnection = null;
        }
    }

    /**
     * Clean up all resources
     */
    function cleanupResources() {
        // Clean up peer connection
        cleanupPeerConnection();

        // Stop all local streams
        localStreams.forEach(stream => {
            stream.getTracks().forEach(track => track.stop());
        });
        localStreams = [];

        // Clear video containers
        $("#localVideoContainer").empty();
        $("#remoteVideoContainer").empty();
        remoteStreams.clear();

        isCallActive = false;
    }

    /**
     * Get a list of available cameras
     * @returns {Promise<MediaDeviceInfo[]>} - List of camera devices
     */
    async function listCameras() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            return devices.filter(device => device.kind === 'videoinput');
        } catch (error) {
            console.error("Error listing cameras:", error);
            showNotification("Failed to list camera devices");
            return [];
        }
    }

    /**
     * Initialize the camera setup UI
     */
    async function initializeCameraSetup() {
        try {
            const cameras = await listCameras();

            if (cameras.length === 0) {
                showNotification("No cameras detected", 5000);
                $("#camera-list").html("<p>No cameras available. Please connect a camera and try again.</p>");
                return;
            }

            $("#camera-list").html(""); // Clear the list

            // Add the first camera by default
            addCameraToSetup(cameras, 0);

            // Enable/disable add camera button based on available cameras
            $("#add-camera-btn").prop('disabled', cameras.length <= 1);
        } catch (error) {
            console.error("Error initializing camera setup:", error);
            showNotification("Failed to initialize camera setup");
        }
    }

    /**
     * Add a camera to the setup UI
     * @param {MediaDeviceInfo[]} cameras - List of available cameras
     * @param {number} index - Setup index
     */
    function addCameraToSetup(cameras, index) {
        const cameraOptions = cameras.map(c => `
            <option value="${c.deviceId}">${escapeHtml(c.label || `Camera ${c.deviceId.slice(0, 5)}...`)}</option>
        `).join('');

        $("#camera-list").append(`
            <div class="camera-setup mb-4">
                <div class="video-preview bg-black relative">
                    <video id="video-${index}" class="w-full h-auto mb-2" autoplay muted></video>
                    <div class="absolute top-2 right-2">
                        <button class="camera-remove-btn bg-red-500 text-white p-1 rounded" data-index="${index}">✕</button>
                    </div>
                </div>
                <div class="camera-controls">
                    <select id="camera-select-${index}" class="w-full p-2 border rounded">
                        ${cameraOptions}
                    </select>
                </div>
            </div>
        `);

        // Start the camera preview
        startCameraPreview(`video-${index}`, cameras[0].deviceId);

        // Handle camera selection change
        $(`#camera-select-${index}`).on('change', function () {
            startCameraPreview(`video-${index}`, $(this).val());
        });
    }

    /**
     * Start camera preview
     * @param {string} videoId - Video element ID
     * @param {string} deviceId - Camera device ID
     */
    async function startCameraPreview(videoId, deviceId) {
        const videoElement = document.getElementById(videoId);

        // Stop any existing stream
        if (videoElement.srcObject) {
            videoElement.srcObject.getTracks().forEach(track => track.stop());
        }

        const constraints = {
            video: { deviceId: { exact: deviceId } },
            audio: true
        };

        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            videoElement.srcObject = stream;
        } catch (error) {
            console.error("Error accessing camera:", error);

            if (error.name === 'NotFoundError') {
                showNotification("Camera not found or has been disconnected");
            } else if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                showNotification("Camera access denied. Please grant permission");
            } else {
                showNotification(`Camera error: ${error.message}`);
            }

            // Show error state in the preview
            $(videoElement).parent().addClass('bg-red-900');
        }
    }

    /**
     * Debugging function to log the state of local streams
     * Logs information about each stream and its tracks
     */
    function logStreamState() {
        console.group("Local Streams State");
        localStreams.forEach((stream, i) => {
            console.log(`Stream ${i}:`, stream.id);
            console.log(`  Video tracks:`, stream.getVideoTracks().length);
            stream.getVideoTracks().forEach((track, j) => {
                console.log(`    Track ${j}:`, track.label, `Enabled: ${track.enabled}`, `Ready: ${track.readyState}`);
            });
            console.log(`  Audio tracks:`, stream.getAudioTracks().length);
            stream.getAudioTracks().forEach((track, j) => {
                console.log(`    Track ${j}:`, track.label, `Enabled: ${track.enabled}`, `Ready: ${track.readyState}`);
            });
        });

        console.log("PeerConnection Senders:");
        if (peerConnection) {
            peerConnection.getSenders().forEach((sender, i) => {
                console.log(`  Sender ${i}:`, sender.track ? sender.track.kind : "no track");
            });
        }
        console.groupEnd();
    }

    /**
    * Add detailed timing logs to track WebSocket and WebRTC events
    */
    function logWithTimestamp(message) {
        const now = new Date();
        const timestamp = `${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}.${now.getMilliseconds()}`;
        console.log(`[${timestamp}] ${message}`);
    }

    /**
     * Create an offer to start a call
     * @param {number} recipientId - Recipient ID
     */
    async function createOffer(recipientId) {
        if (!peerConnection) {
            createPeerConnection();
        }

        try {
            logWithTimestamp("starting to create offer");

            // Ensure all tracks are added (in case they weren't already)
            addLocalStreamsToConnection(peerConnection, localStreams);

            logWithTimestamp("all tracks added, creating offer...");
            const offer = await peerConnection.createOffer({
                offerToReceiveAudio: true,
                offerToReceiveVideo: true
            });

            logWithTimestamp("offer created, setting local description");
            await peerConnection.setLocalDescription(offer);

            logWithTimestamp("local description set, about to send client-offer");
            setTimeout(() => {
                sendSignal('client-offer', peerConnection.localDescription, recipientId, user);
                logWithTimestamp("client-offer signal sent");
            }, 10); // Delay to avoid blocking the event loop
        } catch (error) {
            console.error("Error creating offer:", error);
            showNotification("Failed to create call offer");
            cleanupResources();
        }
    }

    /**
     * Create an answer for an incoming call
     * @param {number} senderId - Sender ID
     * @param {RTCSessionDescription} offer - The offer
     */
    async function createAnswer(senderId, offer) {
        if (!peerConnection) {
            createPeerConnection();
        }

        try {
            await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
            // after remote description set, insert the queued candidate
            candidateQueue.forEach(candidate => peerConnection.addIceCandidate(candidate));
            const answer = await peerConnection.createAnswer();
            await peerConnection.setLocalDescription(answer);
            sendSignal('client-answer', peerConnection.localDescription, senderId, user);
        } catch (error) {
            console.error("Error creating answer:", error);
            showNotification("Failed to answer call");
            cleanupResources();
        }
    }

    /**
     * Add ICE candidate received from remote peer
     * @param {RTCIceCandidate} candidate - ICE candidate
     */
    async function addIceCandidate(candidate) {
        if (!peerConnection) {
            console.warn("Can't add ICE candidate without an active peer connection");
            return;
        }

        try {
            // if remote description is not set, queue the candidate in array
            if (!peerConnection.remoteDescription) {
                console.warn("Remote description not set, queuing ICE candidate");
                candidateQueue.push(candidate);
                return;
            }
            await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
        } catch (error) {
            console.error("Error adding ICE candidate:", error);
        }
    }

    /**
     * Toggle microphone mute state
     */
    function toggleMicrophone() {
        localStreams.forEach(stream => {
            stream.getAudioTracks().forEach(track => {
                track.enabled = !track.enabled;

                // Update button state
                const isMuted = !track.enabled;
                $(muteMicBtn).toggleClass('text-red-400', isMuted);
            });
        });
    }

    /**
     * Toggle camera video state
     */
    function toggleCamera() {
        console.log("Before toggle camera:");
        logStreamState();

        localStreams.forEach(stream => {
            stream.getVideoTracks().forEach(track => {
                track.enabled = !track.enabled;
                console.log(`Toggled video track ${track.label} to enabled=${track.enabled}`);
            });
        });

        // Update button state based on first stream's video track
        if (localStreams.length > 0 && localStreams[0].getVideoTracks().length > 0) {
            const firstTrack = localStreams[0].getVideoTracks()[0];
            const isMuted = !firstTrack.enabled;
            $(muteCamBtn).toggleClass('text-red-400', isMuted);
        }

        console.log("After toggle camera:");
        logStreamState();
    }

    /**
     * End the current call
     */
    async function endCall() {
        try {
            if (user && receiverID) {
                sendSignal('client-hangup', null, receiverID, user);
            }
        } catch (error) {
            console.error("Error ending call:", error);
        } finally {
            cleanupResources();
            hideCallPopup();

            // Reset UI
            $("#profile-container").removeClass('hidden');
            $("#profile-footer").removeClass('hidden');
            $("#video-call-container").addClass('hidden');
            $("#video-call-footer").addClass('hidden');
        }
    }

    /**
 * Properly add multiple local streams to the peer connection
 * This is a key function we'll use to fix the multiple camera issue
 * @param {RTCPeerConnection} pc - The peer connection
 * @param {MediaStream[]} streams - Array of media streams
 */
    function addLocalStreamsToConnection(pc, streams) {
        // Remove any existing tracks
        const senders = pc.getSenders();
        if (senders.length > 0) {
            senders.forEach(sender => {
                pc.removeTrack(sender);
            });
        }

        // Add each track from each stream
        streams.forEach((stream, index) => {
            stream.getTracks().forEach(track => {
                console.log(`Adding ${track.kind} track from stream ${index} to peer connection`);
                pc.addTrack(track, stream);
            });
        });
    }

    /**
 * Add streams sequentially with small delays to avoid overloading
 * @param {RTCPeerConnection} pc - Peer connection
 * @param {MediaStream[]} streams - Array of media streams
 */
    async function addLocalStreamsSequentially(pc, streams) {
        // First, remove any existing tracks
        const senders = pc.getSenders();
        if (senders.length > 0) {
            senders.forEach(sender => {
                logWithTimestamp(`Removing existing track: ${sender.track?.kind || 'unknown'}`);
                pc.removeTrack(sender);
            });

            // Small delay after removing tracks
            await new Promise(resolve => setTimeout(resolve, 50));
        }

        // Add tracks from each stream with small delays between
        for (let i = 0; i < streams.length; i++) {
            const stream = streams[i];
            logWithTimestamp(`Processing stream ${i + 1}/${streams.length} with ID ${stream.id}`);

            const tracks = stream.getTracks();
            for (let j = 0; j < tracks.length; j++) {
                const track = tracks[j];
                logWithTimestamp(`Adding ${track.kind} track from stream ${i}`);
                pc.addTrack(track, stream);

                // Brief delay between adding each track
                await new Promise(resolve => setTimeout(resolve, 20));
            }

            // Slightly longer delay between streams
            if (i < streams.length - 1) {
                await new Promise(resolve => setTimeout(resolve, 50));
            }
        }

        logWithTimestamp(`Added ${streams.length} streams to peer connection`);
    }


    // Button Event Handlers

    // Start call flow
    callBtn.on('click', () => {
        $("#profile-container").addClass('hidden');
        $("#profile-footer").addClass('hidden');
        $("#call-setup-container").removeClass('hidden');
        initializeCameraSetup();
    });

    // Add camera button
    addCameraBtn.on('click', async () => {
        const cameras = await listCameras();
        const cameraCount = $(".camera-setup").length;

        if (cameraCount < cameras.length) {
            addCameraToSetup(cameras, cameraCount);
        } else {
            showNotification("No additional cameras available");
        }

        // Disable button if we've used all cameras
        if (cameraCount + 1 >= cameras.length) {
            $("#add-camera-btn").prop('disabled', true);
        }
    });

    // Remove camera button (delegated event)
    $(document).on('click', '.camera-remove-btn', function () {
        const index = $(this).data('index');
        const videoElement = document.getElementById(`video-${index}`);

        // Stop the stream
        if (videoElement && videoElement.srcObject) {
            videoElement.srcObject.getTracks().forEach(track => track.stop());
        }

        // Remove the camera setup
        $(this).closest('.camera-setup').remove();

        // Re-enable the add camera button
        $("#add-camera-btn").prop('disabled', false);
    });

    // Start call button
    startCallBtn.on('click', async () => {
        try {
            // Create peer connection if not exists
            if (!peerConnection) {
                createPeerConnection();
            } else {
                // Clean up any existing tracks
                peerConnection.getSenders().forEach(sender => {
                    peerConnection.removeTrack(sender);
                });
            }

            // Get user data
            user = await getUser();

            // Gather all selected camera streams
            const cameraSetups = $(".camera-setup");
            // Clear existing streams
            localStreams.forEach(stream => {
                stream.getTracks().forEach(track => track.stop());
            });
            localStreams = [];

            // Clear local video container
            $("#localVideoContainer").empty();

            // Process each camera
            for (let i = 0; i < cameraSetups.length; i++) {
                const deviceId = $(`#camera-select-${i}`).val();

                try {
                    const constraints = {
                        video: { deviceId: { exact: deviceId } },
                        audio: i === 0 // Only use audio from first camera
                    };

                    // More specific error logging
                    console.log(`Requesting access to camera ${i} with deviceId: ${deviceId}`);
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    console.log(`Successfully accessed camera ${i}:`, stream);

                    localStreams.push(stream);

                    // Add to local video container
                    // $("#localVideoContainer").append(`
                    //     <div class="local-video-wrapper relative">
                    //         <video id="localVideo-${i}" class="w-1/2 h-auto bg-black mb-2" autoplay muted></video>
                    //         <div class="text-center text-black">${user.name}</div>
                    //     </div>
                    // `);
                    $("#localVideoContainer").append(`
                        <div class="relative w-full h-[300px] bg-black rounded-lg overflow-hidden shadow-md">
                            <video id="localVideo-${i}" class="w-full h-full object-cover rounded-lg" autoplay muted></video>
                            <div class="absolute bottom-2 left-2 bg-black text-white text-xs px-2 py-1 rounded opacity-80">
                                ${user.name}
                            </div>
                        </div>
                    `);
                    $(`#localVideo-${i}`)[0].srcObject = stream;
                } catch (error) {
                    console.error(`Error accessing camera ${i}:`, error);
                    showNotification(`Failed to access camera ${i + 1}: ${error.message}`);
                }
            }

            if (localStreams.length === 0) {
                throw new Error("No cameras could be accessed");
            }

            // Add all tracks to peer connection using our improved function
            addLocalStreamsToConnection(peerConnection, localStreams);

            logStreamState();
            // Now ready to start call
            sendSignal('is-client-ready', null, receiverID, user);

            // Show call interface
            $("#call-setup-container").addClass('hidden');
            showCallInterface();
            isCallActive = true;

        } catch (error) {
            console.error("Error starting call:", error);
            showNotification(`Failed to start call: ${error.message}`);
            cleanupResources();
        }
    });

    // Call control buttons
    muteMicBtn.on('click', toggleMicrophone);
    muteCamBtn.on('click', toggleCamera);
    hangupBtn.on('click', endCall);

    // Accept incoming call
    acceptBtn.on('click', async () => {
        try {
            user = await getUser();
            hideCallPopup();
            sendSignal('client-is-ready', null, receiverID, user);

            // Show call interface
            showCallInterface();
            isCallActive = true;

        } catch (error) {
            console.error("Error accepting call:", error);
            showNotification("Failed to accept call");
        }
    });

    // Decline incoming call
    declineBtn.on('click', async () => {
        try {
            user = await getUser();
            hideCallPopup();
            sendSignal('client-rejected', null, user.id, user);

        } catch (error) {
            console.error("Error declining call:", error);
        }
    });

    // WebRTC Signaling Event Handlers
    Echo.private(`chat.${authID}`)
        .listenForWhisper('Webrtc', async (message) => {
            const type = message.type;
            const data = message.data;
            const senderId = message.senderID;

            const sender = {
                id: message.senderID,
                name: message.senderName,
                profileImage: message.profileImage
            };

            console.log(`Received ${type} from ${sender.name || 'unknown'}`);

            switch (type) {
                case 'client-candidate':
                    // Add ICE candidate from remote peer
                    if (peerConnection) {
                        await addIceCandidate(data);
                    }
                    break;

                case 'is-client-ready':
                    // Received call request
                    if (isCallActive) {
                        // Already on a call, send busy signal
                        sendSignal('client-already-oncall', null, senderId, user);
                    } else {
                        // set receiver ID
                        receiverID = senderId;
                        // Show incoming call popup
                        showCallPopup(sender.name, sender.profileImage, 'is calling');
                    }
                    break;

                // case 'client-is-ready':
                //     // Other party is ready to receive a call
                //     console.log("Other party is ready to receive a call");
                //     logStreamState();
                //     try {
                //         await createOffer(senderId);
                //         console.log("Offer sent to:", senderId);
                //     } catch (error) {
                //         console.error("Error creating offer:", error);
                //         showNotification("Failed to establish connection");
                //     }
                //     break;

                case 'client-is-ready':
                    // Other party is ready to receive a call
                    logWithTimestamp("Received client-is-ready signal");

                    try {
                        // Add a slight delay before creating the offer
                        // This can help ensure the WebSocket connection is stable
                        setTimeout(async () => {
                            logWithTimestamp("Creating offer after delay");
                            try {
                                await createOffer(senderId);
                            } catch (error) {
                                console.error("Error creating delayed offer:", error);
                                showNotification("Failed to establish connection");
                            }
                        }, 100); // add delay to avoid bloc
                    } catch (error) {
                        console.error("Error in client-is-ready handler:", error);
                        showNotification("Failed to establish connection");
                    }
                    break;

                case 'client-offer':
                    // Received an offer, create an answer
                    try {
                        if (!peerConnection) {
                            createPeerConnection();
                        }

                        // Get user media for answering the call
                        const stream = await navigator.mediaDevices.getUserMedia({
                            video: true,
                            audio: true
                        });

                        localStreams.push(stream);
                        const user = await getUser();
                        // Add to local video container
                        // $("#localVideoContainer").append(`
                        //     <div class="flex flex-col items-center">
                        //         <video id="localVideo-answer" class="w-[400px] h-[300px] bg-black rounded-lg mb-2" autoplay muted></video>
                        //         <div class="text-black text-[14px] text-center">${user.name}</div>
                        //     </div>
                        // `);
                        $("#localVideoContainer").append(`
                            <div class="relative w-full h-[300px] bg-black rounded-lg overflow-hidden shadow-md">
                                <video id="localVideo-answer" class="w-full h-full object-cover rounded-lg" autoplay muted></video>
                                <div class="absolute bottom-2 left-2 bg-black text-white text-xs px-2 py-1 rounded opacity-80">
                                    ${user.name}
                                </div>
                            </div>
                        `);


                        $(`#localVideo-answer`)[0].srcObject = stream;

                        // Add tracks to peer connection
                        stream.getTracks().forEach(track => {
                            peerConnection.addTrack(track, stream);
                        });

                        await createAnswer(senderId, data);
                        showCallInterface();
                        isCallActive = true;

                    } catch (error) {
                        console.error("Error processing offer:", error);
                        showNotification("Failed to process call offer");
                    }
                    break;

                case 'client-answer':
                    // Received an answer to our offer
                    try {
                        if (peerConnection && peerConnection.localDescription) {
                            await peerConnection.setRemoteDescription(new RTCSessionDescription(data));
                            // after remote description set, insert the queued candidate
                            candidateQueue.forEach(candidate => peerConnection.addIceCandidate(candidate));
                        }
                    } catch (error) {
                        console.error("Error processing answer:", error);
                        showNotification("Failed to establish connection");
                    }
                    break;

                case 'client-already-oncall':
                    // Other party is already on a call
                    showCallPopup(sender.name, sender.profileImage, 'is on another call', false);
                    setTimeout(() => {
                        hideCallPopup();
                        cleanupResources();
                    }, 3000);
                    break;

                case 'client-rejected':
                    // Call was rejected
                    showCallPopup(sender.name, sender.profileImage, 'declined the call', false);
                    setTimeout(() => {
                        hideCallPopup();
                        cleanupResources();
                    }, 3000);
                    break;

                case 'client-hangup':
                    // Call was ended by the other party
                    showNotification("Call ended by the other party");
                    setTimeout(() => {
                        endCall();
                    }, 1000);
                    break;
            }
        })
        .on('pusher:subscription_succeeded', function (e) {
            console.log('WebRTC signaling channel subscription succeeded');
        })
        .on('pusher:subscription_error', function (e) {
            console.error('WebRTC signaling channel subscription error', e);
            showNotification("Failed to connect to signaling server");
        });

    // Handle page unload to clean up resources
    $(window).on('beforeunload', function () {
        if (isCallActive) {
            endCall();
        }
        cleanupResources();
    });

    Echo.connector.pusher.connection.bind('state_change', (states) => {
        const { previous, current } = states;
        logWithTimestamp(`WebSocket connection state changed from ${previous} to ${current}`);

        if (previous === 'connected' && current === 'connecting') {
            logWithTimestamp("RECONNECTION DETECTED - WebSocket is reconnecting");
        }

        if (previous === 'connecting' && current === 'connected') {
            logWithTimestamp("RECONNECTION COMPLETE - WebSocket is reconnected");
        }
    });

    Echo.connector.pusher.connection.bind('disconnected', () => {
        logWithTimestamp("WebSocket DISCONNECTED event triggered");
    });

    Echo.connector.pusher.connection.bind('connected', () => {
        logWithTimestamp("WebSocket CONNECTED event triggered");
    });
});
