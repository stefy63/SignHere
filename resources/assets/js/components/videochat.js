/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.min.js');

module.exports = {
    data: function () {
        return {
            conn:'',
            peer: new Peer('user', {key: 'signhere', host: '192.168.136.130', port: 9000, path: '/'}),
            isRecording: false,
        };
    },
    template: require("../templates/videochat.template.html"),
    methods:{
        call:function () {
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mediaDevices.getUserMedia;
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                navigator.getUserMedia({video: true, audio: true}, function (stream) {
                    $('#localVideo').prop('src', URL.createObjectURL(stream));
                    window.localStream = stream;
                    var call = that.peer.call('operator', window.localStream);
                    window.existingCall = call;
                    that.peer.on('call', function(call){
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