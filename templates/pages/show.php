<div class="card text-center">
    <div class="card-header">
        Szczegółowe informacje
    </div>
    <div>
        <?php
        if (!empty($params['error'])) {
            switch ($params['error']) {
                case 'emptyValue':
                    echo '<div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><div>Wszystkie pola muszą być uzupełnione!</div><button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button></div>';
                    break;
            }
        }
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
    </div>
    <div class="card-body">
        <?php $ride = $params['ride'] ?? null ?>
        <?php if ($ride): ?>
            <h5 class="card-title">Id</h5>
            <p class="card-text"><?php echo (int) $ride['id'] ?></p>
            <h5 class="card-title">Taborowy</h5>
            <p class="card-text"><?php echo $ride['tabor'] ?></p>
            <h5 class="card-title">Linia</h5>
            <p class="card-text"><?php echo $ride['line'] ?></p>
            <h5 class="card-title">Kierunek</h5>
            <p class="card-text"><?php echo $ride['direction'] ?></p>
            <h5 class="card-title">Przystanek początkowy</h5>
            <p class="card-text"><?php echo $ride['first'] ?></p>
            <h5 class="card-title">Przystanek końcowy</h5>
            <p class="card-text"><?php echo $ride['last'] ?></p>
            <h5 class="card-title">Utworzono</h5>
            <p class="card-text"><?php echo $ride['created'] ?></p>
        <?php else: ?>
            <p class="card-text">Brak przejazdów do wyświetlenia</p>
        <?php endif; ?>
        <a href="/" class="btn btn-secondary">Powrót</a>
        <a href="/?action=edit&id=<?php echo $ride['id'] ?>" class="btn btn-success">Edytuj</a>
        <a href="/?action=delete&id=<?php echo $ride['id'] ?>" class="btn btn-danger">Usuń</a>
    </div>
    <div class="card-footer text-muted">
        <p>Zaktualizowano: <?php echo $ride['updated'] ? $ride['updated'] : 'nigdy' ?></p>
    </div>
</div>