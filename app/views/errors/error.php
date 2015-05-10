<?php
use Tuum\View\Renderer;

/** @var Renderer $this */

$this->setLayout('layout/layout');

?>

<!-- error: error -->
<h1>A Generic Error Happened</h1>

<p>Don't know what exactly have happened, but some error has happened and that is why you are seeing this screen...</p>
<p>sorry.</p>

<?php
if( isset($trace) && is_array($trace) ) {
    var_dump($trace);
}
?>

