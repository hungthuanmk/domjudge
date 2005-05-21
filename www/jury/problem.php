<?php
/**
 * View a problem
 *
 * $Id$
 */

$id = $_REQUEST['id'];

require('init.php');
$refresh = '15;url=' . getBaseURI() . 'jury/problem.php?id=' . urlencode($id);
$title = 'Problem '.htmlspecialchars(@$id);
require('../header.php');
require('menu.php');

if ( ! $id ) error ("Missing problem id");

if ( isset($_POST['cmd']) && $_POST['cmd'] == 'rejudge' ) {
	rejudge('probid',$id);

	header('Location: ' . getBaseURI() . 'jury/problem.php?id=' . urlencode($id) );
	exit;
}

echo "<h1>Problem ".htmlspecialchars($id)."</h1>\n\n";

$data = $DB->q('TUPLE SELECT * FROM problem NATURAL JOIN contest WHERE probid = %s', $id);

?>
<table>
<tr><td>ID:</td><td><?=htmlspecialchars($data['probid'])?></td></tr>
<tr><td>Name:</td><td><?=htmlentities($data['name'])?></td></tr>
<tr><td>Contest:</td><td><?=htmlspecialchars($data['cid']).' - ' .htmlentities($data['contestname'])?></td></tr>
<tr><td>Allow submit:</td><td><?=printyn($data['allow_submit'])?></td></tr>
<tr><td>Allow judge:</td><td><?=printyn($data['allow_judge'])?></td></tr>
<tr><td>Testdata:</td><td class="filename"><?=htmlspecialchars($data['testdata'])?></td></tr>
<tr><td>Timelimit:</td><td><?=(int)$data['timelimit']?></td></tr>
</table>

<form action="problem.php" method="post">
<p>
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="cmd" value="rejudge" />
<input type="submit" value=" REJUDGE ALL! " />
</p>
</form>

<h2>Submissions for <?=htmlspecialchars($id)?></h2>

<?php
putSubmissions('probid', $id, TRUE);

require('../footer.php');
