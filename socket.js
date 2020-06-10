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
redis.subscribe('ReceiveConnected', function(err, count) {});
redis.subscribe('ReceiveReload', function(err, count) {});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    io.emit(channel + '.' + message.data.lobby.connection_string + ':' + message.event, message.data);
});

io.on('connection', function(socket){
    socket.on('disconnect', function() {
        var lobbyId = parseLobbyId(socket);
        io.emit(`ReceiveLobbyLeave:${lobbyId}`, {'socketId' : socket.id})
    })
})

http.listen(3000, function() {
    console.log('Node server is live!');
});

/**
 * Private Helpers
 */
function parseLobbyId(socket){
    var originExploded = socket.handshake.headers.referer.split('/')
    var lobbyId = originExploded[originExploded.length - 1];
    return lobbyId;
}