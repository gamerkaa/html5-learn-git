## What is msgsys

msgsys is a message passing framework written in PHP. It uses Javascript and PHP for passing messages between two users.
Since the system uses HTTP  on top of PHP it is a slow means of message passing mechanism.

## How it works

Messages are passed by calling Javascript functions and received using javascript callbacks (or simply functions). Anypayload consisting of text without carriage return - linefeed can be passed. Because this mechanism uses HTTP, large payloads can be passed, however text payloads in addition to JSON data are best options. A interval polling mechanism gets the data from server, so netwoek utilised requires decent bandwidth for fast response.

## Uses of msgsys

This mechanism can be used in non-critical applications like chat, multiuser apps, notifications to good effect. The basic needs / required parameters are channel name and username. Thus applications can use channels to track user site data and navigation.

The message system is itself very lightweight and can be learnt quickly.

## Configuration

The settings for msgsys are given in config.php. Alter them for your own database setup.