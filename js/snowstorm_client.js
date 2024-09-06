$( document ).ready(function() {
    console.log( "ready!" );
		function log( message ) {
			$( "<div>" ).text( message ).prependTo( "#codding_log" );
			$( "#codding_log" ).scrollTop( 0 );
		}

const codedfields = document.getElementsByClassName("coded");
let codedfieldsLeft = codedfields.length;
for (const codedfield of codedfields) {
console.log(JSON.stringify(codedfield.id))
		$( "#"+codedfield.id).autocomplete({

			source: function( request, response ) {
				configs = jQuery.parseJSON($("#"+codedfield.id).attr("config"));
				$("#"+codedfield.id).addClass("ui-autocomplete-loading" );
				$.ajax( {
					type: 'POST',
					url: "search.php?text="+$("#"+codedfield.id).val(),
					dataType: "json",
					data: {
						term: request.term,
						server: configs.server,
						branch: configs.branch,
						operation: configs.operation,
						offset :configs.offset,
						limit: configs.limit,
						termactive:configs.termactive,
						groupbyconcept: configs.groupbyconcept,
						semantictag: configs.semantictag,
						method: configs.operation,
						descriptions_sub_path: configs.descriptions_sub_path,
						codes_sub_path: configs.codes_sub_path,
						save_logs:configs.save_logs
					},
					success: function( data ) {
						$("#"+codedfield.id).removeClass("ui-autocomplete-loading" );
						response( data );
					}
				} );
			},
			minLength: 2,
			select: function( event, ui ) {
				configs2 = jQuery.parseJSON($("#"+codedfield.id).attr("config"));
				$("#"+configs2.code_field_id).val(ui.item.id);
				if($('#codding_log').length){
					log( "Selected for field id " +codedfield.id + " the text string: " + ui.item.value + " with associated code: " + ui.item.id );
				}
			}
		});
	}
});