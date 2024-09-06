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

## Snowstorm parameters

<li>termserverurl (required)
<li>branch (required, default MAIN)
<li>operation (required)
<li>activefilter
<li>definitionstatusfilter
<li>termactive
<li>language
<li>preferredin
<li>acceptablein
<li>preferredoracceptablein
<li>ecl
<li>statedecl
<li>conceptids
<li>groupbyconcept
<li>searchmode=standard
<li>semantictag=disorder
<li>limit
<li>offset
<li>searchafter
<li>accept-language
<li>includedescendantcount
<li>form

## Code path and description in response
Similarly, through config parameters, we specify the path of the result that we will take as code and as a description, using dot notation within the items element of the JSON structure returned within "items"

<li>descriptions_sub_path: concept.fsn.term
<li>codes_sub_path: concept.conceptId

## Assignment of the field where to store the code
Optionally it is posible to set the field id to store the code associated with the selected descriptor

<code>&lt;input type="hidden" name="descriptor_code" id="descriptor_code"/></code>

## Log window

If in the page is defined a div or another writable element with the id codding_log a registry of selected descriptors and associated codes will be written


