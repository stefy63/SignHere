<template>
    <div v-show="numCall" id="small-videochat" v-bind:class="[timeOut?'animated wobble':'animated pulse']" >
        <span class="badge badge-danger pull-right">{{ numCall }}</span>
        <a class="open-small-videochat" v-on:click.stop.prevent="accept_call">
            <i class="fa fa-video-camera"></i>
        </a>
    </div>
</template>

<script type="text/javascript">

var socket = require('socket.io-client');

module.exports = {
    props: [
        'skey','shost','sport','spath','ssecure','suser','slocation'
    ],
    data: function () {
        console.log('Connection from: '+this.suser);
        var realport = (this.sport ? this.sport : location.port || (location.protocol === 'https:' ? 443 : 80));

        return {
            Call: [],
            numCall:0,
            setLoop:0,
            io: socket.connect(this.shost+':'+realport),
            timeOut: false,
            userDetail:{userId: this.suser,status:'ready',locations:this.slocation,userType:"operator"}
        };
    },
    created:function () {
        var that=this;

        this.numCall = this.Call.length;

        this.io.emit('welcome-message',this.userDetail );

        this.io.on('new-call-arrived',this.new_call);

        this.io.on('operator-notify-stop-ask-response',this.stop_ask_response);
        this.io.on('operator-notify-response',this.other_response);


    },
    computed: function() {
        var that=this;
        if(this.numCall == 0) {
            $('#small-videochat').hide();
        } else {
            $('#small-videochat').show();
        }
    },
    methods: {
        new_call:function (message) {
            var that = this;
            if(this.Call.indexOf(message.userId) != -1){
                return;
            }
            this.Call.push(message.userId);
            this.numCall = this.Call.length;
            console.log('new-response-arrived......'+message.userId+' - '+this.numCall);
            console.log(JSON.stringify(this.Call));
            if(!that.setLoop){
                that.setLoop = setInterval(function () {
                    that.timeOut = !that.timeOut;
                },3000);
            }

        },
        stop_ask_response:function (message) {
            this.Call.splice($.inArray(message.userId, this.Call), 1 );
            this.numCall = this.Call.length;
            console.log('response-check-user-connection......');
        },
        other_response:function (message) {
            if(message.operatorId != this.suser) this.stop_ask_response(message);
        },
        accept_call:function () {
            var that = this;
            console.log('Small-Chat-Clikked....');

            var user2call = {userToCall: this.Call[0] ,location: that.slocation};
            this.io.emit('accept-call',user2call);
        },
    },




};
</script>

<style scoped>
#small-videochat {
    position: fixed;
    top: 2px;
    left:2px;
    z-index: 100;
}

.open-small-videochat {
  height: 38px;
  width: 38px;
  display: block;
  background: #1ab394;
  padding: 9px 8px;
  text-align: center;
  color: #fff;
  border-radius: 50%;
}
</style>