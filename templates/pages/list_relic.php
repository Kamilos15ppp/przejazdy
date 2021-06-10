<div>
    <h4>Lista zabytków</h4>
    <div class="table-responsive-sm">
        <table class="table table-dark fs-6">
            <thead>
            <tr>
                <th scope="col">Taborowy</th>
                <th scope="col">Producent</th>
                <th scope="col">Model</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($params['vehicles'] ?? [] as $ride): ?>
                <tr>
                    <td><?php echo $ride['tabor']  ?></td>
                    <td><?php echo $ride['producer']  ?></td>
                    <td><?php echo $ride['model']  ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>