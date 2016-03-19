<?php
$viewData['title'] = 'Specialties';
?>
    <h3>Users</h3> <?php $html->link('Create Specialty', 'create', 'specialties') ?>
    <hr>
    <table class="table table-hover" id="specialties-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Име</th>
            <th>Кратко име</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Изтриване на специалност</h4>
                </div>
                <div class="modal-body">
                    <p>Сигурни ли сте, че искате да изтриете тази специалност?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Цъ</button>
                    <button type="button" class="btn btn-primary" id="confirm-deletion">Да</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php

$sections['scripts-bottom'] = function(){
    echo '<script src="/js/specialties.js"></script>';
};