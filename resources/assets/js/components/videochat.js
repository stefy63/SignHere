/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');
//var PeerJs = require('peer');

module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','soperator','slocation'
    ],
    data: function () {
        return {
            peer: '',
            isRecording: false,
        };
    },
    template: require("../templates/videochat.template.html"),
    created:function () {
        console.log('created.....');
        console.log(this.skey,this.shost,this.sport,this.spath,this.ssecure,this.suser,this.soperator,this.slocation);
        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia;

        var realthis = this;
        var port = (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80));
        //var socket = require('socket.io');
        var peer = new Peer(this.suser,
            {
                key: this.skey,
                host: this.shost,
                port: port,
                path: this.spath,
                secure: (this.ssecure == true)?true:false,
                config:{
                    'iceServers': [{
                        url: 'stun:stun.ekiga.net'
                    }, {
                        url: 'stun:stun.l.google.com:19302'
                    }, {
                        url: 'stun:stun1.l.google.com:19302'
                    }, {
                        url: 'stun:stun2.l.google.com:19302'
                    }, {
                        url: 'stun:stun3.l.google.com:19302'
                    }, {
                        url: 'stun:stun4.l.google.com:19302'
                    }]
                }
            });

        peer.on('open', function() {
            console.log('opened.....'+peer.id);
        });

        peer.on('error', function(err) {
            console.log(err.message);
        });

        peer.on('call', function(call) {
            call.answer(window.localStream);
            console.log('call from Operator.....');
            realthis.isRecording = !realthis.isRecording;
            realthis.wait_stream(call);
        });

        navigator.getUserMedia({ audio: true, video: true}, function (stream) {
            console.log('getUserMedia ......');
            window.localStream = stream;
            $('#localVideo').prop('src',  URL.createObjectURL(stream));
        }, function(err){console.log(err);});

        this.peer = peer;

    },
    methods:{
        calling:function () {
            console.log('Call Operator ......');
            var that = this;
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                console.log('isRecording ......');
                var call = that.peer.call(this.soperator, window.localStream);
                that.wait_stream(call);
            } else {
                window.existingCall.close();
                $('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            }
        },
        wait_stream: function (call) {
            var that = this;
            console.log(' wait_stream...');
            if (window.existingCall) {
                window.existingCall.close();
            }
            call.on('stream', function(stream){
                console.log('call in stream...');
                $('#remoteVideo').prop('src', URL.createObjectURL(stream));
            });
            call.on('close', function () {
                console.log('close call...');
                window.existingCall.close();
                if (that.isRecording) {
                    that.isRecording = !that.isRecording;
                }
                //$('#localVideo').prop('src','');
                $('#remoteVideo').prop('src','');
            });
            window.existingCall = call;
        }
    }


};