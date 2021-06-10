<div>
    <div>
        <?php
            if (!empty($params['error'])) {
                switch ($params['error']) {
                    case 'missingRideId':
                        echo 'Niepoprawny identyfikator przejazdu';
                        break;
                    case 'rideNotFound':
                        echo 'Przejazd nie został znaleziony';
                        break;
                }
            }
        ?>
    </div>
    <div>
        <?php
            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Przejazd został utworzony';
                        break;
                    case 'edited':
                        echo 'Przejazd został zaktualizowany';
                        break;
                }
            }
        ?>
    </div>
    <?php
        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'created';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 10;
        $currentPage = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;
    ?>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sortModal">Sortuj</button>
    <div class="modal fade" id="sortModal" tabindex="-1" aria-labelledby="sortModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sortModalLabel">Wybierz sortowanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form class="" action="/" method="get">
                            <div class="m-2">
                                Sortuj po
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sortby" id="flexRadioDefault1" value="tabor" <?php echo $by === 'tabor' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Taborowym
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sortby" id="flexRadioDefault2" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Dacie
                                    </label>
                                </div>
                            </div>
                            <div class="m-2">
                                Kierunek sortowania
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sortorder" id="flexRadioDefault3" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Rosnąco
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sortorder" id="flexRadioDefault4" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> >
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Malejąco
                                    </label>
                                </div>
                            </div>
                            <div class="m-2">
                                Ilość przejazdów na stronie
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pagesize" id="flexRadioDefault5" value="1" <?php echo $size === 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault5">
                                        1
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pagesize" id="flexRadioDefault6" value="5" <?php echo $size === 5 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault6">
                                        5
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pagesize" id="flexRadioDefault7" value="10" <?php echo $size === 10 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault7">
                                        10
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pagesize" id="flexRadioDefault8" value="20" <?php echo $size === 20 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault8">
                                        20
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Sortuj</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive-sm">
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Taborowy</th>
                <th scope="col">Linia</th>
                <th scope="col">Kierunek</th>
                <th scope="col">Opcje</th>
                <!--                <th scope="col">Początkowy</th>-->
<!--                <th scope="col">Końcowy</th>-->
            </tr>
            </thead>
            <tbody>
                <?php foreach ($params['rides'] ?? [] as $ride): ?>
                    <tr>
                        <td><?php echo $ride['tabor']  ?></td>
                        <td><?php echo $ride['line']  ?></td>
                        <td><?php echo $ride['direction']  ?></td>
                        <td><a href="/?action=show&id=<?php echo $ride['id'] ?>"><button class="btn btn-sm btn-warning">Szczegóły</button></a></td>
<!--                        <td>--><?php //echo $ride['first']  ?><!--</td>-->
<!--                        <td>--><?php //echo $ride['last']  ?><!--</td>-->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
    $paginationUrl = "&pagesize=$size&sortby=$by&sortorder=$order";
    ?>
    <div class="container d-flex align-item-center justify-content-center">
        <ul class="pagination">
            <?php if ($currentPage !== 1) : ?>
            <?php endif; ?>
            <li class="page-item <?php echo $currentPage !== 1 ? '' : 'disabled' ?>">
                <a class="page-link" href="/?page=<?php echo $currentPage - 1 . $paginationUrl ?>" tabindex="-1" aria-disabled="true">Poprzednia</a>
            </li>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $currentPage ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <?php for ($i = 1; $i <= $pages; $i++) : ?>
                        <li class="page-item <?php echo $currentPage === $i ? 'active' : '' ?>" aria-current="page">
                            <a class="page-link" href="/?page=<?php echo $i . $paginationUrl ?>"><?php echo $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <li class="page-item <?php echo $currentPage < $pages ? '' : 'disabled' ?>">
                <a class="page-link" href="/?page=<?php echo $currentPage + 1 . $paginationUrl ?>">Następna</a>
            </li>
            <?php if ($currentPage < $pages) : ?>
            <?php endif; ?>
        </ul>
    </div>
</div>