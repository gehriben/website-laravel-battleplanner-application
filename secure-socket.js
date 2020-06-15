var fs = require('fs');
var https = require('https');
var Redis = require('ioredis');
var redis = new Redis();
var express = require('express');
var app = express();

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/beta.battleplanner.io/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/beta.battleplanner.io/fullchain.pem')
};
var serverPort = 3000;

var server = https.createServer(options, app);
var io = require('socket.io')(server);

redis.subscribe('RequestBattleplan', function(err, count) {});
redis.subscribe('ResponseBattleplan', function(err, count) {});
redis.subscribe('ReceiveDrawDelete', function(err, count) {});
redis.subscribe('ReceiveDrawCreate', function(err, count) {});
redis.subscribe('ReceiveOperatorSlotChange', function(err, count) {});
redis.subscribe('ReceiveDrawUpdate', function(err, count) {});
redis.subscribe('ReceiveConnected', function(err, count) {});
redis.subscribe('ReceiveReload', function(err, count) {});

redis.on('message', function(channel,message) {
    message = JSON.parse(message);
    io.emit(channel + '.' + message.data.identifier + ':' + message.event, message.data);
});

server.listen(serverPort, function() {
    console.log('server up and running at %s port', serverPort);
});

/**
 * Private Helpers
 */
function parseLobbyId(socket){
    var originExploded = socket.handshake.headers.referer.split('/')
    var lobbyId = originExploded[originExploded.length - 1];
    return lobbyId;
}
