<section class="content-header">
    
    <h1>
        <?= $this->fetch('content-title') ?>
        <small>
            <?= $this->fetch('content-description') ?>
        </small>
    </h1>
    
    <?= $this->element('breadcrumb') ?>

</section>

<section class="content">

  <?= $this->fetch('content') ?>

</section>