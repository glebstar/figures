<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Figures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css?v=<?=$scriptVersion;?>">
</head>
<body>
  <div class="container">
      <div class="row g-3 align-items-center">
          <div class="col-auto">
              <label for="newGroupInput" class="col-form-label">Новая группа</label>
          </div>
          <div class="col-auto">
              <input type="text" id="newGroupInput" class="form-control" aria-describedby="newGroupInput">
          </div>
          <div class="col-auto">
              <input type="button" id="newGroupButton" class="form-control btn btn-primary" value="Добавить группу">
          </div>
      </div>

      <div class="row g-3 align-items-center">
          <div class="col-auto btn-group" id="figures">
              <?php foreach ($figures as $figure):?>
              <a href="#" class="btn btn-primary" data-figure-id="<?=$figure['id'];?>"><?=$figure['name'];?></a>
              <?php endforeach;?>
          </div>
          <div class="col-auto">
              <input type="number" min="10" max="100" id="sizeInput" class="form-control ccc" placeholder="Размер" value="50">
          </div>
          <div class="col-auto">
              <input type="color" class="form-control form-control-color" id="colorInput" value="#FF0000" title="Выберите цвет">
          </div>
          <div class="col-auto">
              <input type="button" id="newFigureButton" class="form-control btn btn-primary" value="Добавить фигуру">
          </div>
      </div>

      <div class="accordion" id="accGroups">
          <?php foreach ($groups as $group):?>
          <div class="accordion-item">
              <h2 class="accordion-header" data-group-n="<?=$group['id'];?>">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$group['id'];?>" aria-expanded="false" aria-controls="collapse<?=$group['id'];?>">
                      <?=htmlspecialchars($group['name']);?>
                  </button>
              </h2>
              <div id="collapse<?=$group['id'];?>" class="accordion-collapse collapse" data-bs-parent="#accGroups">
                  <div class="accordion-body">
                      <canvas id="canvas-<?=$group['id'];?>" width="800" height="400">
                      </canvas>
                  </div>
              </div>
          </div>
          <?php endforeach;?>
      </div>

      <canvas id="canvas-4" width="600" height="300"></canvas>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jcanvas/22.0.1/umd/jcanvas.min.js"></script>
  <script src="/js/jquery.cookies.js"></script>

  <script>
      let results = [];
      <?php foreach ($results as $result):?>
      results.push({
          group: <?=$result['group_id'];?>,
          figure: <?=$result['figure_id'];?>,
          size: <?=$result['size'];?>,
          color: '<?=$result['color'];?>'
      });
      <?php endforeach;?>

      let groupsCoord = [];
      <?php foreach ($groups as $group):?>
      groupsCoord.push({
         id: <?=$group['id'];?>,
         x: 50,
         y: 50
      });
      <?php endforeach;?>
  </script>

  <script src="/js/script.js?v=<?=$scriptVersion;?>"></script>
</body>
</html>
