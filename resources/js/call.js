$(function(){

    $(document).on('click', '#callBtn', () => {
        let sendTo = $("#callBtn").data('user');

        Echo.private(`chat.${sendTo}`).whisper('Webrtc', {message:"Test Tiwi"});
        });

    Echo.private(`chat.${authID}`).listenForWhisper('Webrtc', (e) => {
        console.log(e)
    });
});
