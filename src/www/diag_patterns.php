<?php
/*
	Copyright (C) 2014 Deciso B.V., All rights reserved
	Exec+ v1.02-000 - Copyright 2001-2003, All rights reserved
	Created by André Ribeiro and Hélder Pereira

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:

	1. Redistributions of source code must retain the above copyright notice,
	   this list of conditions and the following disclaimer.

	2. Redistributions in binary form must reproduce the above copyright
	   notice, this list of conditions and the following disclaimer in the
	   documentation and/or other materials provided with the distribution.

	THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
	INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
	AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
	AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
	OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
	SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
	INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
	CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
	ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
	POSSIBILITY OF SUCH DAMAGE.
*/

require("guiconfig.inc");

//Move the upload file to /usr/local/share/protocols (is_uploaded_file must use tmp_name as argument)
if (($_POST['submit'] == gettext("Upload Pattern file")) && is_uploaded_file($_FILES['ulfile']['tmp_name'])) {
	if(fileExtension($_FILES['ulfile']['name'])) {
		if (!is_array($config['l7shaper']['custom_pat']))
			$config['l7shaper']['custom_pat'] = array();

		$config['l7shaper']['custom_pat'][$_FILES['ulfile']['name']] = base64_encode(file_get_contents($_FILES['ulfile']['tmp_name']));
		write_config(sprintf(gettext("Added custom l7 pattern %s"), $_FILES['ulfile']['name']));
		move_uploaded_file($_FILES['ulfile']['tmp_name'], "/usr/local/share/protocols/" . $_FILES['ulfile']['name']);
		$ulmsg = gettext("Uploaded file to") . " /usr/local/share/protocols/" . htmlentities($_FILES['ulfile']['name']);
	}
	else
		$ulmsg = gettext("Warning: You must upload a file with .pat extension.");
}

//Check if file has correct extension (.pat)
function fileExtension($nameFile) {
	$format = substr($nameFile, -4);
	return ($format == ".pat");
}

$pgtitle = array(gettext("Diagnostics"), gettext("Add layer7 pattern"));
include("head.inc");
?>

<body>
<?php include("fbegin.inc"); ?>

	<section class="page-content-main">

		<div class="container-fluid">

			<div class="row">

			    <section class="col-xs-12">

				<div class="content-box">

                        <form action="diag_patterns.php" method="post" enctype="multipart/form-data" name="frmPattern">

				<?php if ($ulmsg) echo "<p class=\"text-danger\"><strong>" . $ulmsg . "</strong></p>\n"; ?>

				<div class="table-responsive">
					<table class="table table-striped table-sort">
									<tr>
										<td colspan="2" valign="top" class="listtopic"><?=gettext("Upload layer7 pattern file");?></td>
									</tr>
									<tr>
										<td align="right"><strong><?=gettext("File to upload:");?></strong></td>
										<td valign="top" >
											<input name="ulfile" type="file" class="formfld file" id="ulfile" />
										</td>
									</tr>
									<tr>
										<td valign="top" width="22%"></td>
										<td valign="top" width="78%">
											<input name="submit" type="submit" class="btn btn-primary" id="upload" value="<?=gettext("Upload Pattern file");?>" />
										</td>
									</tr>
								</table>
				</div>
                        </form>
				</div>
			    </section>
			</div>
		</div>
	</section>

<?php include("foot.inc"); ?>
