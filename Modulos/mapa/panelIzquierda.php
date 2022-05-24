<style>
  .ui-jqgrid .ui-jqgrid-btable { cursor : pointer; }
</style>
<script type="text/template" id="tplDialogMapaEquipo">
<div class="modal-header headerDiv">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">×</span>
        </button>
        <div class="text-center">
              <i class="fa fa-desktop fa-4x mb-3" style="color: deepskyblue;"><span class="textDiv"><?php echo traducir('EQUIPO'); ?></span></i>
        </div>
        <hr>        
      </div>
      <div class="modal-body">
        <form id="" name="">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">local_atm</i>
                  <span class="materialDiv"><?php echo traducir('Equipo'); ?></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span id="spidEquipo" name="spidEquipo" class=""><%-idEquipo%></span>
                </div>
              </div>              
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">vpn_key</i>
                  <span class="materialDiv"><?php echo traducir('Serie'); ?></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%-serie%></span>
                </div>
              </div>                             
              <div class="row">
                <div class="col-md-12 form-group">          
                  <i class="material-icons materialDiv">preview</i>
                  <span class="materialDiv"> <?php echo traducir('Tipo de Equipo'); ?></span>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%-tipo%></span>
                </div>
              </div>               
              <div class="row">
                <div class="col-md-12 form-group">          
                  <i class="material-icons materialDiv">place</i>
                  <span class="materialDiv"><?php echo traducir('Dirección'); ?></span>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%-direccion%></span>
                </div>
              </div>              
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-center">
          <div class="col-md-12">
            <button style="width:100%" class="btn peach-gradient btn-rounded z-depth-1" type="button" id="btnAbrirTransacciones" name="btnAbrirTransacciones" data-idequipo="<%-idEquipo%>"><?php echo traducir('Abrir'); ?></button>            
          </div>
      </div>
</script>

<script type="text/template" id="tplDialogMapaTransaccionDetalle">
  <div class="modal-header headerDiv">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true" class="white-text">×</span>
    </button>
    <div class="text-center">
        <i class="fa fa-desktop fa-4x mb-3" style="color: deepskyblue;"><span class="textDiv"><?php echo traducir('DETALLE '); ?></span></i>
    </div>
      <hr>        
  </div>
  <div class="modal-body">
        <form id="" name="">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12 form-group">
                  <button id="AbrirTransaccionDetalleComposicion" name="AbrirTransaccionDetalleComposicion" type="button" class="btn btn-info btn-sm btn-round" value="<%-id%>">
                    <i class="material-icons">insert_chart_outlined</i><?php echo traducir('Composición'); ?>
                  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">face</i>
                  <span class="materialDiv">  Cliente</span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%- cliente%></span>
                </div>
              </div>              
              <div class="row">
                <div class="col-md-12 form-group">                
                  <i class="material-icons materialDiv">check_circle_outline</i>
                  <span class="materialDiv">  Acción</span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%- operacion%></span>
                </div>
              </div>                             
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">credit_card</i>                
                  <span class="materialDiv">  Tipo de Transacción</span>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%-transaccion%></span>
                </div>
              </div>               
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">monetization_on</i>
                  <span class="materialDiv">  Monto</span>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%- monto%> - <%- signo%> - <%- moneda%></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <i class="material-icons materialDiv">insert_invitation</i>
                  <span class="materialDiv">  Fecha</span>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-12">
                  <span class=""><%-fechaHora%></span>
                </div>
              </div>      
            </div>
          </div>
        </form>
      </div>
</script>
<script type="text/template" id="tplError">
  <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Atenci&oacute;n!</strong> <%-msn%>
  </div>
</script>

<div class="modal fade left" id="dialogEquipo" role="dialog">
  <div class="modal-dialog modal-full-height modal-left modal-notify modal-info" role="document">
    <div class="modal-content" style="height: fit-content;min-height: -webkit-fill-available;">

    </div>
  </div>
</div>

<div class="modal fade" id="dialogTransacciones" role="dialog">
  <div class="modal-dialog modal-full-height modal-notify modal-info div2"  role="document">
    <div class="modal-content" style="height: fit-content;min-height: -webkit-fill-available;">
    <div class="modal-header headerDiv">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">×</span>
        </button>
          <div class="text-center">
              <i class="fa fa-handshake-o fa-4x mb-3" style="color: deepskyblue;"><span class="textDiv"><?php echo traducir('TRANSACCIONES'); ?></span></i>
          </div>
            <hr>        
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6 form-group">
                <button id="btnExportarTran" name="btnExportarTran" class="btn btn-info btn-sm btn-round">
                  <i class="material-icons">backup</i><?php echo traducir('Exportar'); ?>
                </button>
              </div>
              <div class="col-md-6 form-group">
                 <span style="color: #00bcd4">ARS: </span><span id="spARS" name="spARS">0</span><br>
                 <span style="color: #00bcd4">USD: </span><span id="spUSD" name="spUSD">0</span><br>
                 <span style="color: #00bcd4">BRL: </span><span id="spBRL" name="spBRL">0</span><br>
                 <span style="color: #00bcd4">EUR: </span><span id="spEUR" name="spEUR">0</span>
              </div>              
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div id="tblEquipoTransacciones" name="tblEquipoTransacciones">
                    <table id="tblDatos" style="font-size: small;width: fit-content !important;">
                    </table>
                    <div id="pagDatos" style="width: fit-content !important;"></div>
                  </div>  
              </div>
            </div>                
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dialogTransaccionDetalle" role="dialog">
  <div class="modal-dialog modal-full-height modal-notify modal-info div3"  role="document">
    <div class="modal-content" style="height: fit-content;min-height: -webkit-fill-available;">
    </div>
  </div>
</div>

<div class="modal fade" id="dialogTransaccionDetalleComposicion" role="dialog">
  <div class="modal-dialog modal-full-height modal-notify modal-info div4"  role="document">
    <div class="modal-content" style="height: fit-content;min-height: -webkit-fill-available;">
      <div class="modal-header headerDiv">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">×</span>
        </button>
          <div class="text-center">
              <i class="fa fa-bar-chart fa-4x mb-3" style="color: deepskyblue;"><span class="textDiv"><?php echo traducir('COMPOSICION'); ?></span></i>
          </div>
            <hr>        
      </div>
      <div class="modal-body">
        <form id="" name="">
          <div class="row">
            <div class="col-md-12">
              <canvas id="chartTransaccionDetalleComposicion" width="600" height="700"></canvas>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-center">
          <div class="col-md-12">

          </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"  src="../../inc/chartjs/chartjs.min.js"></script>
<script type="text/javascript"  src="../mapa/js/panelIzquierda.js?v=1.5"></script>