<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'lib/autoloader.php';

$mapper = new \DataMapper\CharacterMapper();

if (isset($_FILES['character']) && is_readable($_FILES['character']['tmp_name'])) {
  $ch = $mapper->read($_FILES['character']['tmp_name']);
}
else {
  $ch = $mapper->read('CHAR.CHR');
}
//echo "<pre>"; var_dump($ch); echo "</pre>";

$json = file_get_contents('schema.json');
$schema = json_decode($json, true);

$json = file_get_contents('spells.json');
$spells = json_decode($json, true);

$innate_lookup = isset($ch->memorized_spells['innate']) ? array_count_values($ch->memorized_spells['innate']) : [];
foreach ($spells['innate'] as $spell) {
  $id = $spell['id'];
  if (!isset($innate_lookup[$id])) {
    $innate_lookup[$id] = 0;
  }
}


$json = file_get_contents('colors.json');
$colors = json_decode($json, true);


$json = file_get_contents('items.json');
$items = json_decode($json, true);



function render_text($field) {
    global $ch;
    
    $id = $field['id'];
    $label = isset($field['label']) ? $field['label'] : ucwords(str_replace("_", " ", $id));
    
    $attributes = "";
    foreach ($field['attributes'] as $key => $value) {
        $attributes .= "$key=\"$value\" ";
    }
    
    return <<<EOT
<div class="form-group">
  <label for="{$id}">{$label}</label>
  <input type="text" class="form-control" id="{$id}" name="{$id}" placeholder="{$label}" {$attributes} value="{$ch->$id}" required>
</div>
EOT;
}




function render_number($field) {
    global $ch;
    
    $id = $field['id'];
    $label = isset($field['label']) ? $field['label'] : ucwords(str_replace("_", " ", $id));
    
    $attributes = "";
    foreach ($field['attributes'] as $key => $value) {
        $attributes .= "$key=\"$value\" ";
    }
    
    return <<<EOT
<div class="form-group">
  <label for="{$id}">{$label}</label>
  <input type="number" class="form-control" id="{$id}" name="{$id}" placeholder="{$label}" {$attributes} value="{$ch->$id}" required>
</div>
EOT;
}



function render_select($field) {
    global $ch;
    
    $id = $field['id'];
    $label = isset($field['label']) ? $field['label'] : ucwords(str_replace("_", " ", $id));
    
    $options = "";
    foreach ($field['options'] as $name => $value) {
        $is_selected = ($value == $ch->$id) ? "selected" : "";
        $options .= "<option value=\"$value\" $is_selected>$name</option>";
    }
    
    return <<<EOT
<div class="form-group">
  <label for="{$id}">{$label}</label>
  <select class="form-control" id="{$id}" name="{$id}">
    {$options}
  </select>
</div>
EOT;
}



function render_color($field) {
  global $ch, $colors;

  $id = $field['id'];
  $label = isset($field['label']) ? $field['label'] : ucwords(str_replace("_", " ", $id));

  $color_to_option = function ($color) use ($ch, $id) {
    $is_selected = ($color['id'] == $ch->$id) ? " selected" : "";
    return '<option value=' . $color['id'] . $is_selected . '>' . $color['name'] . '</option>';
  };
  $options = implode("", array_map($color_to_option, $colors));

  return <<<EOT
<div class="form-group">
  <label for="{$id}">${label}</label>
  <select class="form-control" id="{$id}" name="{$id}">
    {$options}
  </select>
</div>
EOT;
}



function render_item($field) {
  global $ch, $items;

  $id = $field['id'];
  $label = isset($field['label']) ? $field['label'] : ucwords(str_replace("_", " ", $id));

  $item_to_option = function ($item) use ($ch, $id) {
    $is_selected = (!is_null($ch->items[$id]) && $item['id'] == $ch->items[$id]->name) ? " selected" : "";
    return '<option value=' . $item['id'] . $is_selected . '>' . $item['name'] . '</option>';
  };
  $section_to_optgroup = function ($name, $items) use ($item_to_option) {
    return '<optgroup label="' . $name . '">' . implode("", array_map($item_to_option, $items)) . '</optgroup>';
  };
  $options = implode("", array_map($section_to_optgroup, array_keys($items), $items));

  $get_charges = function ($id) use ($ch) {
    return !is_null($ch->items[$id]) ? $ch->items[$id]->charges1 : 0;
  };

  return <<<EOT
  <div class="form-group row">
    <label for="{$id}" class="col-sm-4 text-right">${label}:</label>
    <div class="col-sm-4">
      <select class="form-control" id="{$id}" name="items[{$id}][name]">
        {$options}
      </select>
    </div>
    <div class="col-sm-4">
      <input type="number" min="0" max="255" name="items[{$id}][charges1]" class="form-control" placeholder="charges" required value="{$get_charges($id)}">
    </div>
    <input type="hidden" name="items[{$id}][creation_hour]" value="0">
    <input type="hidden" name="items[{$id}][expiration_time]" value="0">
    <input type="hidden" name="items[{$id}][charges2]" value="0">
    <input type="hidden" name="items[{$id}][charges3]" value="0">
    <input type="hidden" name="items[{$id}][flags]" value="1">
  </div>
EOT;
}



function render_field($field) {
    switch($field['type']) {
        case 'text': return render_text($field);
        case 'number': return render_number($field);
        case 'select': return render_select($field);
        case 'color': return render_color($field);
        case 'item': return render_item($field);
        default: return "unknown";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Infinity Character Generator</title>
    <link rel="canonical" href="http://infinitychgen.altervista.org">
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <meta name="author" content="Marco Zanella">
    <meta name="keywords" content="infinity,engine,character,generator,editor,modify">
    <meta name="description" content="Character generator and editor for the Infinity Engine, supports games like Baldur's Gate.">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  </head>
  
  <body>
    <div class="page-header">
      <h1>Infinity Engine Character Generator</h1>
    </div>


    <!-- Upload a character to edit -->
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <p>
            This is a <strong>character creator and editor</strong> for the Infinity Engine. You can set your character's attributes (such as abilities, skills and alike) and press the "Generate Character File" button to get your file ready to be imported in your game.
          </p>
          <p>
            You can start <strong>creating</strong> your character using the form below, or you can upload a <em>character file (*.chr)</em> to <strong>edit</strong> an existing character.
          </p>
          <p>
            Note this tool allows creation of non-legit characters, such as evil paladins or fighter/mage/thief halflings.
          </p>
          <p>
            If you want to contribute, check out <a href="https://github.com/marco-zanella/infinity-chgen">Infinity Engine Character Generator repository on GitHub</a>.
          </p>
        </div>

        <div class="col-sm-4">
          <form method="POST" enctype="multipart/form-data" class="">
            <fieldset>
              <legend>Upload a character file (optional)</legend>
              <div class="form-group">
                <label for="upload-chr">Character file</label>
                <input type="file" name="character" id="upload-chr">
              </div>
              <button type="submit" class="btn btn-default btn-block">Start modifying</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>


    <!-- Character creation/edit -->
    <section class="container" itemscope itemtype="http://schema.org/CreativeWork">
      <h2>Character Customization</h2>

      <form method="POST" action="char.php">
        <!-- Regular sections -->
        <?php
          $i = 0;
          foreach ($schema as $section_name => $section):
        ?>

          <?php if ($i % 6 == 0): ?>
          <div class="clearfix visible-lg-block"></div>
          <?php elseif ($i % 4 == 0): ?>
          <div class="clearfix visible-md-block"></div>
          <?php elseif ($i % 3 == 0): ?>
          <div class="clearfix visible-sm-block"></div>
          <?php endif; ?>
        <fieldset class="col-sm-4 col-md-3 col-lg-2">
          <legend><?= $section_name ?></legend>
          <?php foreach ($section as $field):
            echo render_field($field);
          endforeach; ?>
        </fieldset>
        <?php
          $i++;
          endforeach;
        ?>
        
        
        
        <!-- Memorizable spells -->
        <fieldset class="col-xs-12">
          <legend>Memorizable spells</legend>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Level</th>
                <?php for ($i = 1; $i < 10; ++$i) { echo "<th>$i</th>"; } ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Priest</td>
                <?php for ($i = 1; $i < 8; ++$i): ?>
                  <td>
                    <input type="number" class="form-control" name="memorizable_spells[priest][<?= $i ?>]" min="0" max="64" required value="<?= $ch->memorizable_spells['priest'][$i] ?>">
                  </td>
                <?php endfor; ?>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Wizard</td>
                <?php for ($i = 1; $i < 10; ++$i): ?>
                  <td>
                    <input type="number" class="form-control" name="memorizable_spells[wizard][<?= $i ?>]" min="0" max="64" required value="<?= $ch->memorizable_spells['wizard'][$i] ?>">
                  </td>
                <?php endfor; ?>
              </tr>
            </tbody>
          </table>
        </fieldset>



        <!-- Known spells -->
        <fieldset class="col-xs-12">
          <legend>Known spells</legend>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Level</th>
                <?php for ($i = 1; $i < 10; ++$i) { echo "<th>$i</th>"; } ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Priest</td>
                <?php for ($i = 1; $i < 8; ++$i): ?>
                  <td>
                    <select class="form-control tooltip-list" name="known_spells[priest][<?= $i ?>][]" multiple size="10">
                      <optgroup label="Priest">
                      <?php foreach ($spells['priest'] as $spell): ?>
                        <option value="<?= $spell['id']?>" title="<?= $spell['name'] ?>, level <?= $spell['level'] ?> priest spell" <?php if (isset($ch->known_spells['priest'][$i]) && in_array($spell['id'], $ch->known_spells['priest'][$i])) { echo "selected"; } ?>>
                          <?= $spell['name'] ?>
                        </option>
                      <?php endforeach; ?>
                      </optgroup>

                      <optgroup label="Wizard">
                      <?php foreach ($spells['wizard'] as $spell): ?>
                        <option value="<?= $spell['id']?>" title="<?= $spell['name'] ?>, level <?= $spell['level'] ?> wizard spell" <?php if (isset($ch->known_spells['priest'][$i]) && in_array($spell['id'], $ch->known_spells['priest'][$i])) { echo "selected"; } ?>>
                          <?= $spell['name'] ?>
                        </option>
                      <?php endforeach; ?>
                      </optgroup>
                    </select>
                  </td>
                <?php endfor; ?>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Wizard</td>
                <?php for ($i = 1; $i < 10; ++$i): ?>
                  <td>
                    <select class="form-control tooltip-list" name="known_spells[wizard][<?= $i ?>][]" multiple size="10">
                      <optgroup label="Priest">
                      <?php foreach ($spells['priest'] as $spell): ?>
                        <option value="<?= $spell['id']?>" title="<?= $spell['name'] ?>, level <?= $spell['level'] ?> priest spell" <?php if (isset($ch->known_spells['wizard'][$i]) && in_array($spell['id'], $ch->known_spells['wizard'][$i])) { echo "selected"; } ?>>
                          <?= $spell['name'] ?>
                        </option>
                      <?php endforeach; ?>
                      </optgroup>

                      <optgroup label="Wizard">
                      <?php foreach ($spells['wizard'] as $spell): ?>
                        <option value="<?= $spell['id']?>" title="<?= $spell['name'] ?>, level <?= $spell['level'] ?> wizard spell" <?php if (isset($ch->known_spells['wizard'][$i]) && in_array($spell['id'], $ch->known_spells['wizard'][$i])) { echo "selected"; } ?>>
                          <?= $spell['name'] ?>
                        </option>
                      <?php endforeach; ?>
                      </optgroup>
                    </select>
                  </td>
                  <?php endfor; ?>
              </tr>
            </tbody>
          </table>
        </fieldset>



        <!-- Innate spells -->
        <fieldset class="col-xs-12">
          <legend>Innate Spells</legend>
          <?php
            $i = 0;
            foreach ($spells['innate'] as $spell):
          ?>
          <?php if ($i % 4 == 0): ?>
          <div class="clearfix visible-md-block visible-lg-block"></div>
          <?php elseif ($i % 3 == 0): ?>
          <div class="clearfix visible-sm-block"></div>
          <?php endif; ?>

          <div class="form-group col-sm-4 col-md-3">
            <label for="<?= $spell['id'] ?>"><?= $spell['name'] ?></label>
            <input type="number" name="innate_spells[<?= $spell['id'] ?>]" id="<?= $spell['id'] ?>" class="form-control" value="<?= $innate_lookup[$spell['id']] ?>" placeholder="<?= $spell['name'] ?>">
          </div>
          <?php
            $i++;
            endforeach;
          ?>
        </fieldset>



        <!-- Equipped items -->
        <fieldset class="col-sm-6">
          <legend>Equipped items</legend>
          <?php
          $slots = [
            'helmet',
            'armor',
            'shield',
            'gloves',
            'left_ring',
            'right_ring',
            'amulet',
            'belt',
            'boots',
            'weapon1',
            'weapon2',
            'weapon3',
            'weapon4',
            'quiver1',
            'quiver2',
            'quiver3',
            'quiver4',
            'cloack',
            'quickitem1',
            'quickitem2',
            'quickitem3'
          ];
          foreach ($slots as $slot):
            echo render_item(['id' => $slot]);
          endforeach;
          ?>
        </fieldset>



        <!-- Carried items -->
        <fieldset class="col-sm-6">
          <legend>Carried items</legend>
          <?php
          for ($i = 1; $i <= 16; ++$i):
            echo render_item(['id' => "inventory$i"]);
          endfor;
          ?>
        </fieldset>
        

      
        <button class="btn btn-primary btn-block">Generate Character File</button>
      </form>
    </section>
    
    
    
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>