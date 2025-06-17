<style type="text/css">
    
    .<?php echo $unid; ?>.map-module-wrapper {
        position: relative;
        overflow: hidden;
    }

    .<?php echo $unid; ?>.map-module-wrapper .map-module-content-wrapper {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 100%;
        max-width: <?php echo $scargs['contentwidth']; ?>px;
        left: -<?php echo $scargs['contentwidth'];  ?>px;
        background: #ffffff;
    }


    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon-1 {
        --cluster-color: <?php echo $scargs['primarycolor']; ?>;
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon-2 {
        --cluster-color: <?php echo $scargs['secondarycolor']; ?>;
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon-3 {
        --cluster-color: <?php echo $scargs['tertiarycolor']; ?>;
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon {
        background: var(--cluster-color);
        color: #fff;
        border-radius: 100%;
        font-weight: bold;
        font-size: 15px;
        display: flex;
        align-items: center;
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon::before,
    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon::after {
        content: "";
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;

        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        background: var(--cluster-color);
        opacity: 0.2;
        border-radius: 100%;
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon::before {
        padding: calc(<?php echo $scargs['clustersize']; ?>px - 7px);
    }

    .<?php echo $unid; ?>.map-module-wrapper .custom-clustericon::after {
        padding: <?php echo $scargs['clustersize']; ?>px;
    }

</style>