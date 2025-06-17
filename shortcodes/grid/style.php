<style type="text/css">
.customers.grid-module-wrapper {
    display: grid;
    grid-template-columns: repeat(<?php echo $scargs['perrow']; ?>, minmax(0, 1fr));
    gap: 1rem;
}

.customers.grid-module-wrapper .cbtn {
    background: <?php echo $scargs['primarycolor']; ?>;
}

.customers.grid-module-wrapper .cbtn:hover {
    background: <?php echo $scargs['hovercolor']; ?>;
}

.customers.grid-module-wrapper .csgridtitle {
    color: <?php echo $scargs['secondarycolor']; ?>;
    font-weight: 900;
}

@media screen and (max-width: 1200px) {
    .customers.grid-module-wrapper {
        grid-template-columns: repeat(<?php echo $scargs['perrowlg']; ?>, minmax(0, 1fr));
    }
}

@media screen and (max-width: 992px) {
    .customers.grid-module-wrapper {
        grid-template-columns: repeat(<?php echo $scargs['perrowmd']; ?>, minmax(0, 1fr));
    }
}

@media screen and (max-width: 768px) {
    .customers.grid-module-wrapper {
        grid-template-columns: repeat(<?php echo $scargs['perrowsm']; ?>, minmax(0, 1fr));
    }
}

@media screen and (max-width: 576px) {
    .customers.grid-module-wrapper {
        grid-template-columns: repeat(<?php echo $scargs['perrowxs']; ?>, minmax(0, 1fr));
    }
}
</style>