<h1>Chi tiết Danh Mục</h1>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $category['id']; ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $category['name']; ?></td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td>
            <?php echo date('d-m-Y H:i:s', strtotime($category['createdAt'])); ?>
        </td>
    </tr>
    <tr>
        <th>Updated_at</th>
        <td>
            <?php echo date('d-m-Y H:i:s', strtotime($category['updatedAt'])); ?>
        </td>
    </tr>
</table>
<a class="btn btn-primary" href="index.php?controller=danhmucsach">Back</a>

