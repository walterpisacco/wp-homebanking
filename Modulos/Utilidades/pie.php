  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/popper.js"></script>
  <script src="../../js/bootbox.js"></script>  
  <script src="../../js/bootstrap-material-design.min.js"></script>
  <script src="../../js/perfect-scrollbar.jquery.min.js"></script>
  <script src="../../js/moment.min.js"></script>
  <script src="../../js/jquery.validate.min.js"></script>
  <script src="../../js/jquery.bootstrap-wizard.js"></script>
  <script src="../../js/bootstrap-selectpicker.js"></script>
  <script src="../../js/bootstrap-datetimepicker.min.js"></script>
  <script src="../../js/jquery.dataTables.js"></script>
  <script src="../../js/bootstrap-tagsinput.js"></script>
  <script src="../../js/fullcalendar.min.js"></script>
  <script src="../../js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <script src="../../js/jquery.redirect.js"></script>
  <script src="../../js/demo.js"></script>
  
  <script src="../../inc/guriddoJqgrid/js/i18n/grid.locale-es.js" type="text/javascript" ></script>
  <script src="../../inc/guriddoJqgrid/js/jquery.jqGrid.min.js?v1" type="text/javascript" ></script>
  <script src="../../inc/backbonejs/underscore-min.js" type="text/javascript" ></script>
  <script src="../../inc/notify/bootstrap-notify.js"></script>
  <script src="../../inc/switch1/js/bootstrap-switch.js" type="text/javascript"></script>

  <script type="text/javascript" src="../../inc/daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="../../inc/daterangepicker/daterangepicker.min.js"></script>

  <script type="text/javascript"  src="../Utilidades/Js/funciones.js?v=1.3"></script>
  <script type="text/javascript"  src="../diccionario/diccionario.js?v=1.3"></script>
  <!--script type="text/javascript"  src="../../inc/mqtt/mqtt.min.js"></script-->
  <!--script type="text/javascript"  src="../Utilidades/Js/conexionMQTT.js?v=1.6"></script-->
  <script type="text/javascript"  src="../Utilidades/Js/alertas.js?v=1.1"></script>

<script>
  $(document).ready(function() {

  });

  function limpiar(){
    $('.limp').val('');
      $(".label-floating").each(function() {
      $(this).removeClass('is-filled');
    });
  }

  /**
   * Devuelve un objeto con el formato de filtro establecido acorde
   * las opciones de busqueda seleccionadas
   *
   * @return Object
   */
  function formatFilter(params) {
    var filterGroup = {'groupOp': 'AND',op: 'eq',text: 'any','rules': []},
      filterObject= {'field': '','op': 'eq','data': ''};
    filterGroup.rules = _.filter(params, function(elem) {
      return (!_.isEmpty(elem.value) && !_.isUndefined(elem.value) && elem.value !== '-1');
    }).map(function(elem) {
       
      var rule = _.clone(filterObject);
      rule.field = elem.name;
      rule.data = elem.value;
       
      return rule;
    });
    return JSON.stringify(filterGroup);

  }

 function toggleGifLoad(){
    $('#preloader').toggle();
  }


</script>


<footer class="footer">
  <div class="container-fluid">
  </div>
</footer>

</body>

</html>