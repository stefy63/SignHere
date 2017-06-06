/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.min.js');

module.exports = {
    data: function () {
        return {
            conn:'',
            isRecording: false,
            room: 'sign_here',
            videoRecorder: null,
            recordingData: [],
            dataUrl: ''
        };
    },
    template: require("../templates/videochat.template.html"),
    methods:{
        call:function () {
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                var peer = new Peer('user', {key: 'signhere', host: 'localhost', port: 9000, path: '/'});
                navigator.getUserMedia({video: true, audio: true}, function (stream) {
                    $('#localVideo').prop('src', URL.createObjectURL(stream));
                    window.localStream = stream;
                    var call = peer.call('operator', window.localStream);
                    window.existingCall = call;
                    peer.on('call', function(call){
                        // Answer the call automatically (instead of prompting user) for demo purposes
                        call.answer(window.localStream);
                    });
                    call.on('stream', function(stream){
                        $('#remoteVideo').prop('src', URL.createObjectURL(stream));
                    });
                }, function(err){console.log(err);});
            } else {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            };
        },
    }


};