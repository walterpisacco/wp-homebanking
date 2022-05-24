<script type="text/javascript">
$(document).ready(function(){
	$("#dialog_acerca_de").dialog({
		autoOpen: false,
		// show: "slide",
		// hide: "slide",
	    stack: false,
	    resizable:false,
	    modal:true,
	    zIndex: 900,
	    title:"Acerca de ...",
	    height:300,
	    width:580
	});
});
function openDialogAcercaDe(){
	$('#dialog_acerca_de').dialog('open');
}
</script>
<div id="dialog_acerca_de" style="z-index: 1050; display:none;">
	<table>
		<tr>
			<td><strong>Sistema:</strong></td>
			<td><?php echo APPLARGENAME;?></td>
		</tr>
		<tr>
			<td><strong>Version:</strong></td>
			<td><?php echo APPVERSION;?></td>
		</tr>
		<tr>
			<td><strong>Contacto:</strong></td>
			<td><?php echo APPHELPDESK;?></td>
		</tr>
		<tr>
			<td><strong>Copyrigth:</strong></td>
			<td><?php echo APPCOPYRIGHT;?></td>
		</tr>
	</table>
</div>
