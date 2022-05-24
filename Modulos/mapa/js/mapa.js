Mapa = (function(a){
    this._mapa 				= null,
    this._cluesterLayer 	= null,
    this._comunasLayer		= null,
    this._heatmapLayer 		= null,
    this._infoLegend		= null,
    this._tileServer        = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}',
    this._tileServerKey     = 'pk.eyJ1Ijoid3Bpc2FjY28iLCJhIjoiY2tlYnZ4cHF0MDM2aTJ5bW9xaHlqbnZ2NSJ9.4DOXQMLber1Z3AFC4XJDSA',
    this._defEpokGeolayer	= {url:'//epok.buenosaires.gob.ar/getGeoLayer/',symbols_url:'//static.usig.buenosaires.gob.ar/symbols//',backgrounds_url:'//static.usig.buenosaires.gob.ar/images/markers/fondos//',crs:{'type': 'name','properties': {'name': 'urn:ogc:def:crs:EPSG::7433'}},crsWGS:{'type': 'name','properties': {'name': 'urn:ogc:def:crs:EPSG::4326'}}},
    this._heatmapLayeOpt	= {"radius": 30,"scaleRadius": false,"useLocalExtrema": true,latField: 'lat',lngField: 'lng',valueField: 'count'};
    self 					= this;

    _initMapa = function(a){
        self._cluesterLayer 	= L.markerClusterGroup();//Inicializar layer del Cluster
        self._mapa = L.map(a).setView([-34.597624,-58.455515], 13);

        L.tileLayer(self._tileServer, {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: self._tileServerKey
        }).addTo(self._mapa);
        return self;
    }

    this._createPrinterControl = function(){
        L.control.browserPrint({
            title: 'Impresora',
            documentTitle: 'Mapa Busqueda de Actuaciones',
            printLayer: L.tileLayer('//mapa.buenosaires.gob.ar/mapcache/tms/1.0.0/amba_con_transporte_3857@GoogleMapsCompatible/{z}/{x}/{y}.png', {
                maxZoom: 18,
                minZoom: 9,
                tms: !0
            }),
            contentSelector:'.leaflet-browser-print-content',
            closePopupsOnPrint: false,
            printModes: [
                L.control.browserPrint.mode.landscape('Horizontal','A4'),
                L.control.browserPrint.mode.portrait('Vertical','A4'),
                L.control.browserPrint.mode.custom("Selecione la Zona", "A4")
            ],
            manualMode: false
        }).addTo(self._mapa);
        return self;
    }

    this._createSwitchControl = function(){
        let baseMaps = {
            "<b>Mapa de Puntos</b>": self._cluesterLayer,
            "<b>Mapa de Temperatura</b>": self._heatmapLayer
        };
        var overlayMaps = {
            "Comunas": self._comunasLayer,
            "Comisarias":self._comisariasLayer
        };

        L.control.layers(baseMaps,overlayMaps).addTo(self._mapa);
        $('.leaflet-control-layers-list :radio:first').trigger('click');// Ver una manera mas elegante
        $('.leaflet-control-layers-overlays :checkbox').trigger('click');
        return self;
    }

    this._createLegend = function(){
        self._infoLegend = L.control({position: 'topright'});
        self._infoLegend.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info legend leaflet-browser-print-content');
            this._div.innerHTML ='<b>Encontrados:</b><span>0</span> || <b>Graficados:</b><span>0</span>';
            return this._div;
        };
        self._infoLegend.update = function(a,b){
            this._div.innerHTML = '<b>Encontrados:</b><span>'+a+'</span> || <b>Graficados:</b><span>'+b+'</span>';
        }
        self._infoLegend.addTo(self._mapa);
        return  self;
    }

    this.updateLegends = function(total,render){
        total 	= total   || 0;
        render 	= render  || 0;
        self._infoLegend.update(total,render);
        return self;
    }

    this.addMarkers = function(arraypts){
        self._cluesterLayer.addLayers(arraypts).addTo(self._mapa);
        return self;
    }

    this._clearMakers = function(){
        self._cluesterLayer.clearLayers();
        return self;
    }

    this.clearMap = function(){
        self._clearMakers();
        return self;
    }

    _initMapa(a);
});
var collection = [];
$(document).ready(function () {
    $('#mapa_contenedor').css({'height': 800}); 
    let oMapa = new Mapa('mapa_contenedor');
    
    oMapa.clearMap(); // Limpiar busqueda anterior
	getDataMapaEquiposFromServer().done(function(data){
		collection = data;
		addMarkers(collection);
    }).fail(setError);
        
	function getDataMapaEquiposFromServer(){
	   toggleGifLoad();
	   return $.ajax('Search/EquiposList_get.php', {
	        async: true,dataType: 'json'    
        }).always(toggleGifLoad);

    }
    
	function setError(xhr){
		let template = _.template($('#tplError').html());
		$('.header').append(template({msn:xhr.responseText}));
    }
    
	function addMarkers(data){
		data        = data || [];
        let marks   = [];   
		_.map(data,function(elem){
			try{
				if(!_.isEmpty(elem.posX) && !_.isEmpty(elem.posY)){
                    marker = L.marker([elem.posX,elem.posY],{elem, 
                        icon: new L.divIcon({
                            className: 'marca',
                            html: '<img class="my-div-image" src="../../img/icono_caja.png"/>'
                        })
                    }).on('click',showDialogDetalle);  

                    marks.push(marker);                  
/*                    
                    marker = L.marker([elem.posX,elem.posY],{elem})
                                  .on('click',showDialogDetalle);
					marks.push(marker);
*/
/*
                    var icon = L.marker([elem.posX,elem.posY], {
                        icon: L.divIcon({
                            className: 'icono-objetivo',
                            html: 'nombre de caja'
                       })
                    });

                    marks.push(icon);
*/                    
				}			
			}catch(err){//Esto es por si da error alguna latlng
					return;
			}			
		});

		oMapa.addMarkers(marks);
    }
    
    function showDialogDetalle(marker){
        let data = marker.sourceTarget.options,
            template  = _.template($('#tplDialogMapaEquipo').html());
        $('#dialogEquipo .modal-content').empty().append(template(data.elem));
        $('#dialogEquipo').modal('show');
    }
});

