/**
 * Created by root on 05/06/17.
 */
var PeerJs = require('../peer.js');
//var PeerJs = require('peer').ExpressPeerServer;
var socket = require('socket.io-client');


module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','slocation'
    ],
    data: function () {
        var realport = (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80));

        return {
            io: socket.connect(this.shost+':'+realport),
            isRecording: false,
            timeOut: false,
        };
    },
    template: require("../templates/operator.template.html"),
    created:function () {
        var that=this;
        setInterval(function () {
            that.timeOut = !that.timeOut;
        },3000);

    }


};