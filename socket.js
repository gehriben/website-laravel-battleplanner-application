var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('RequestBattleplan', function(err, count) {});
redis.subscribe('ResponseBattleplan', function(err, count) {});
redis.subscribe('ReceiveDrawDelete', function(err, count) {});
redis.subscribe('ReceiveDrawCreate', function(err, count) {});
redis.subscribe('ReceiveOperatorSlotChange', function(err, count) {});
redis.subscribe('ReceiveDrawUpdate', function(err, count) {});


redis.on('message', function(channel, message) {
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + '.' + message.data.identifier + ':' + message.event, message.data);
});

http.listen(3000, function() {
    console.log('Node server is live!');
});