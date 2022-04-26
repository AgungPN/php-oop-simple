<?php require_once "app/init.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <!-- Daisy UI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@1.20.1/dist/full.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2/dist/tailwind.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <h1 class="text-2xl m-5 text-center font-bold">Users</h1>
  <div class=" container mx-auto">
    <div class="fleat">
      <label for="addModal" class="btn btn-primary mb-4 btn-xs modal-button">Add User</label>
      <form action="" method="get" class="inline-block float-right">
        <div class="form-control">
          <div class="relative">
            <input type="text" placeholder="Search" name="keyword" autocomplete="off" class="w-full pr-10 input input-primary input-sm input-bordered">
            <button name="search" type="submit" class="absolute btn-sm top-0 right-0 rounded-l-none btn btn-primary">Search</button>
          </div>
        </div>
      </form>
    </div>
    <table class="table w-full table-zebra">
      <thead>
        <tr>
          <th></th>
          <th>Image</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($users as $user) : ?>
          <tr class="hover">
            <th><?= $i++; ?></th>
            <td>
              <div class="avatar">
                <div class=" rounded-btn w-20 h-20">
                  <img src="<?= asset("image/$user->image") ?>" alt="image">
                </div>
              </div>
            </td>
            <td><?= $user->name ?></td>
            <td><?= $user->email ?></td>
            <td>
              <form action="" method="POST" class="inline">
                <input type="hidden" name="id_user" value="<?= $user->id; ?>">
                <button class="btn btn-error btn-xs" type="submit" name="delete" onclick="return confirm('are you sure?');">delete</button>
              </form>
              <label for="editModal<?= $user->id ?>" class="ml-3 btn btn-success btn-xs modal-button">Edit</label>
            </td>
          </tr>

          <!-- Modal Edit -->
          <input type="checkbox" id="editModal<?= $user->id ?>" class="modal-toggle">
          <div class="modal">
            <div class="modal-box">

              <!-- modal content -->
              <h3 class="text-center font-bold">Edit User</h3>
              <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?= $user->id; ?>">
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Name</span>
                  </label>
                  <input type="text" name="name" placeholder="name" value="<?= $user->name ?>" class="input input-bordered" required>
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Email</span>
                  </label>
                  <input type="email" placeholder="Email" name="email" value="<?= $user->email ?>" class="input input-bordered" required>
                </div>
                <div class="avatar">
                  <div class=" rounded-btn w-20 h-20 mt-3">
                    <img class="show-img-preview" src="<?= asset("image/$user->image") ?>">
                  </div>
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Image</span>
                  </label>
                  <input type="file" class="input input-bordered" onchange="showPreview(event);" accept="image/*" name="image">
                </div>

                <div class="modal-action">
                  <button type="submit" name="update" for="editModal" class="btn btn-success">Submit</button>
                  <label for="editModal<?= $user->id ?>" class="btn">Close</label>
                </div>
              </form>
            </div>
          </div>
          <tr>
          <?php endforeach ?>
      </tbody>
    </table>

    <!-- pagination -->
    <div class="btn-group" id="btn-group">
      <?php $i = 1 ?>
      <a href="?page=<?php
                      if (isset($_GET['page'])) {
                        if ($_GET['page'] > $i) echo $_GET['page'] - 1;
                        else echo $i;
                      }
                      ?>" class="btn">Previous</a>
      <?php while ($i <= $lenPage) : ?>
        <a href="?page=<?= $i; ?>" class="btn page <?= $i == $_GET['page'] ? 'btn-active' : ''; ?>"><?= $i; ?></a>
        <?php $i++ ?>
      <?php endwhile ?>
      <a href="?page=<?php
                      if (isset($_GET['page'])) {
                        if ($_GET['page'] >= $lenPage) echo $lenPage;
                        else echo $_GET['page'] + 1;
                      }
                      ?>" class="btn">Next</a>
    </div>
  </div>
</body>

<!-- MODAL -->
<!-- Modal Add -->
<input type="checkbox" id="addModal" class="modal-toggle">
<div class="modal">
  <div class="modal-box">

    <!-- modal content -->
    <h3 class="text-center font-bold">Add User</h3>
    <form method="POST" action="" enctype="multipart/form-data">
      <div class="form-control">
        <label class="label">
          <span class="label-text">Name</span>
        </label>
        <input type="text" name="name" placeholder="name" class="input input-bordered" required>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input type="email" placeholder="Email" name="email" class="input input-bordered" required>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Password</span>
        </label>
        <input type="password" placeholder="Password" name="password" class="input input-bordered" required>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Image</span>
        </label>
        <input type="file" class="input input-bordered" accept="image/*" name="image" required>
      </div>

      <div class="modal-action">
        <button type="submit" name="add" for="addModal" class="btn btn-primary">Submit</button>
        <label for="addModal" class="btn">Close</label>
      </div>
    </form>
  </div>
</div>

<script>
  function showPreview(event) {
    if (event.target.files.length > 0) {
      let src = URL.createObjectURL(event.target.files[0])
      let preview = document.getElementsByClassName("show-img-preview")
      preview.src = src
    }
  }

  // https://www.w3schools.com/howto/howto_js_active_element.asp

  // let btnConstainer = document.getElementById('btn-group')
  // let btns = btnConstainer.getElementsByClassName('page')
  // for (let i = 0; i < btns.length; i++) {
  //   btns[i].addEventListener('click', function() {
  //     let current = document.getElementsByClassName('btn-active')
  //     // If there's no active class
  //     if (current.length > 0) {
  //       current[0].className = current[0].className.replace(" btn-active", "");
  //     }
  //     this.className += ' btn-active'
  //   })
  // }
</script>

</html>