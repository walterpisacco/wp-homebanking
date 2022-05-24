var clientBroker = 'cajas_'+localStorage.getItem("idCliente")+ '_' + localStorage.getItem("usuario")+'_'+localStorage.getItem("sesion");

const options = {
     // connectTimeout: 4000,
      // Authentication
      clientId: clientBroker,//'laguardiana@gmail.com',//localStorage.getItem("usuario"),
      username: 'weblg',//localStorage.getItem("usuario"),
      password: 'weblg123456',//localStorage.getItem("pass"),
      keepalive: 2000,
      connectTimeout: 2000,
      messageExpiryInterval: 1200,
      clean: false,
    properties: { // MQTT 5.0 properties
      sessionExpiryInterval: 1234,
      receiveMaximum: 432,
      maximumPacketSize: 100,
      topicAliasMaximum: 456,
      requestResponseInformation: true,
      requestProblemInformation: true
  }      
}

var connected = false;
//const WebSocket_URL = 'ws://platform.drexgen.com:8083/mqtt';
const WebSocket_URL = 'wss://lg.drexgen.com:8084/mqtt';
const client = mqtt.connect(WebSocket_URL, options);


client.on('connect', () => {
  usuario = 1;
  console.log('usuario '+clientBroker+' Mqtt conectado a '+WebSocket_URL);
  $('#spConexion').text('DECH Conectado...');
  $('#imgConexion').attr('src','../../img/conectado_verde.gif');  
})

client.on('error', err => {
  console.log('usuario '+clientBroker+' Mqtt desconectado de '+WebSocket_URL);
  $('#spConexion').text('DECH Drexgen Desconectado...');
  $('#imgConexion').attr('src','../../img/conectado_rojo.gif');
    client.reconnect() ;
  });

client.on('close', err => {
  console.log('usuario '+clientBroker+' Mqtt desconectado de '+WebSocket_URL);
  $('#spConexion').text('DECH Drexgen Desconectado...');
  $('#imgConexion').attr('src','../../img/conectado_rojo.gif');
    client.reconnect() ;
  });




