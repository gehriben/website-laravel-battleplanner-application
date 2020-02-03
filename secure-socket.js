var fs = require('fs');
var https = require('https');

var Redis = require('ioredis');
var redis = new Redis();

var express = require('express');
var app = express();

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/battleplanner.io/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/battleplanner.io/fullchain.pem')
};
var serverPort = 3000;

var server = https.createServer(options, app);
var io = require('socket.io')(server);

redis.subscribe('BattleplanChange', function(err, count) {});
redis.subscribe('BattlefloorDraw', function(err, count) {});
redis.subscribe('BattlefloorDelete', function(err, count) {});
redis.subscribe('ChangeOperatorSlot', function(err, count) {});

redis.on('message', function(channel,message) {
    //console.log('Message Received: ' + message);
    message = JSON.parse(message);
    io.emit(channel + '.' + message.data.identifier + ':' + message.event, message.data);
});

server.listen(serverPort, function() {
    console.log('server up and running at %s port', serverPort);
});

