<div class="card text-center">
    <div class="card-header">
        Usuwanie przejazdu
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
            <form action="/?action=delete" method="post">
                <input type="hidden" name="id" value="<?php echo $ride['id'] ?>">
                <button type="submit" class="btn btn-danger">Usuń</button>
            </form>
        <?php else: ?>
            <p class="card-text">Brak przejazdów do wyświetlenia</p>
        <?php endif; ?>
        <a href="/?action=show&id=<?php echo $ride['id'] ?>" class="btn btn-secondary">Powrót</a>
        <a href="/" class="btn btn-secondary">Powrót do listy przejazdów</a>
    </div>
    <div class="card-footer text-muted">
        <p>Zaktualizowano: <?php echo $ride['updated'] ? $ride['updated'] : 'nigdy' ?></p>
    </div>
</div>