# AJAXTerminologyServerClient
A JavaScript and CSS library to link input text fields with a terminology server (SnowStorm tested). Matching options are displayed as text box is written, and finally the code associated with the selected descriptor is saved in another field (text or hidden field)
# Dependencies
Jquery and JqueryUI are required, and files js/snowstorm_client.js and css/snowstorm_client.css mus be included too.

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">

	<script src="js/snowstorm_client.js"></script>
	<link rel="stylesheet" href="css/snowstorm_client.css">

 # AJAX Server

 The executable server (search.php) must be in the root directory with de actual configuration. You can place it wherever you want changing the path in the AJAX call in snowstorm_client.js (line 19)

 				$.ajax( {
					type: 'POST',
					url: "search.php?text="+$("#"+codedfield.id).val(),
					dataType: "json",

# Input box settings

Any text input with class=coded will be detected by the loaded functions and used as input fields to search in the terminolgy server. 

In the text field name and id properties are required and must be equal. Class must have value "coded" and a config propertie with all the parameters coded in JSON. 

<code>&lt;input id="descriptor" name="descriptor" config='{"server":"https://snowstorm-training.snomedtools.org/snowstorm/snomed-ct/browser", "branch":"MAIN", "operation":"descriptions", "offset":"0", "limit":"50","termactive":"true","groupbyconcept":"false", "semantictag":"organism", "descriptions_sub_path": "concept.fsn.term", "codes_sub_path":"concept.conceptId","save_logs":"true", "code_field_id":"descriptor_code"}' class="coded"/></code>

