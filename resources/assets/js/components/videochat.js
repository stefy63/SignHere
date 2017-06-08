/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');

module.exports = {
    data: function () {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia;
        return {
            peer: new Peer('user',
                {
                    key: 'signhere',
                    host: 'videortc.3punto6.com',
                    port: location.port || (location.protocol === 'https:' ? 443 : 80),
                    path: '/videostream',
                    secure: true
                }),
            isRecording: false,
        };
    },
    template: require("../templates/videochat.template.html"),
    methods:{
        calling:function () {
            console.log('Call ......');
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                console.log('isRecording ......');
                navigator.getUserMedia({ audio: true, video: true}, function (stream) {
                    console.log('inStream ......');
                    $('#localVideo').prop('src', URL.createObjectURL(stream));
                    window.localStream = stream;
                }, function(err){console.log(err);});

                var call = that.peer.call('operator', window.localStream);
                if (window.existingCall) {
                    window.existingCall.close();
                }
                call.on('stream', function(stream){
                    $('#remoteVideo').prop('src', URL.createObjectURL(stream));
                });
                call.on('close', function () {
                    this.isRecording = !this.isRecording;
                    this.calling();
                });
                window.existingCall = call;
            } else {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            };
        },
    }


};