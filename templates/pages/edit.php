<div class="container">
    <h4> Edytuj przejazd </h4>
    <div>
        <?php if (!empty($params['ride'])): ?>
            <?php $ride = $params['ride']; ?>
            <form action="/?action=edit" method="post">
                <input type="hidden" name="id" value="<?php echo $ride['id'] ?>">
                <div class="mb-3">
                    <label for="exampleInputTaborowy" class="form-label">Taborowy</label>
                    <input type="text" name="tabor" class="form-control" id="exampleInputTaborowy" value="<?php echo $ride['tabor'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputLInia" class="form-label">Linia</label>
                    <input type="text" name="line" class="form-control" id="exampleInputLinia" value="<?php echo $ride['line'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputKierunek" class="form-label">Kierunek</label>
                    <input type="text" name="direction" class="form-control" id="exampleInputKierunek" value="<?php echo $ride['direction'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPoczatkowy" class="form-label">Początkowy</label>
                    <input type="text" name="first" class="form-control" id="exampleInputPoczatkowy" value="<?php echo $ride['first'] ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputKoncowy" class="form-label">Końcowy</label>
                    <input type="text" name="last" class="form-control" id="exampleInputKoncowy" value="<?php echo $ride['last'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Zaktualizuj</button>
            </form>
            <?php else: ?>
<!--            <p>Brak danych do wyświetlenia</p>-->
            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>Brak danych do wyświetlenia</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <a href="/?action=show&id=<?php echo $ride['id'] ?>"><button class="btn btn-secondary">Powrót</button></a>
            <a href="/"><button class="btn btn-secondary">Powrót do listy przejazdów</button></a>
    </div>
</div>