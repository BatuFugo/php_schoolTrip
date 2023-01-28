<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pausa</title>
</head>
<body>
    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "esercitazioni informatica";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_REQUEST['btn_sub']))
    {
        setcookie('gita', $username, time() + (86400 * 30), "/");
        $username = $_SESSION['username'];
        $btn_subval = $_REQUEST['sources'];
        
        $sql = 'SELECT destinazioni.destinazione, AVG(classi.prezzo) AS "mediaPrezzo", COUNT(classi.id_classi) AS "numClassi" FROM classi, destinazioni WHERE classi.id_destinazione = destinazioni.id AND classi.id_destinazione = ' . $btn_subval;
        $sql2 = 'SELECT classi.classe, classi.prezzo, classi.id_destinazione FROM classi, destinazioni WHERE classi.id_destinazione= destinazioni.id AND classi.id_destinazione = ' . $btn_subval;


        $result = $conn->query($sql);
        $resulti = $conn->query($sql);
        $classi = $conn->query($sql2);
        $ggg = $resulti->fetch_assoc();

        if($ggg['numClassi']==0)
        { 
            echo 'Nessuna classe ha visitato questa meta';
        }
        elseif($result->num_rows > 0 )
        {
            $row = $result->fetch_assoc();
            echo 'Benvenuto ' . $username . ', <br>' . 'Destinazione: ' . $row['destinazione'] . '<br> Prezzo: ' . $row['mediaPrezzo'] . '<br> Numero Classi: ' . $row['numClassi']. '<br>';
            while($class = $classi->fetch_assoc()){
                echo 'AAA' . $class['classe'] . 'BBB' . $class['prezzo'] . '<br>';
            }
        }
        
    }
    else
    {
        $_SESSION['username'] = "Cattaneo Antonio";

        $sql = 'SELECT id, destinazione FROM destinazioni';
        $result = $conn->query($sql);
        
        echo 
        '
        <div class="title">
         SELEZIONA LA TUA DESTINAZIONE  
        </div>
        ';
        echo '
        <form method="post">
        <section id="header-container">
        <select name="sources">
        ';

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //echo $row['id'] . "° destinazione " . $row['destinazione'];
            echo '<option value="' . $row['id'] . '">' . $row['destinazione'] . '</option>';
        }
        } else {
        echo "0 results";
        }
        $conn->close();

        echo '
        </select>
        </section>



        <input class="noselect" type="submit" name="btn_sub">
    </form>';
    }
    ?>
    <script>
        
    (function() {

var CuteSelect = CuteSelect || {};

FIRSTLOAD = true;
SOMETHINGOPEN = false;

CuteSelect.tools = {
  canRun: function() {
    var myNav = navigator.userAgent.toLowerCase();
    var browser = (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
    if(browser) {
      return (browser > 8) ? true : false;
    } else { return true; }
  },
  uniqid: function() {
    var n= Math.floor(Math.random()*11);
    var k = Math.floor(Math.random()* 1000000);
    var m = String.fromCharCode(n)+k;
    return m;
  },
  hideEverything: function() {
    if(SOMETHINGOPEN) {
      SOMETHINGOPEN = false;
      targetThis = false;
      var cells = document.getElementsByTagName('div');
      for (var i = 0; i < cells.length; i++) {
        if(cells[i].hasAttribute('data-cuteselect-options')) { 
          var parent = cells[i].parentNode;
          cells[i].style.opacity = '0';
          cells[i].style.display = 'none';
        }
      }
    }
  },
  getStyle: function() {
    var css = '';
    var stylesheets = document.styleSheets;
    var css = '';
    for(s = 0; s < stylesheets.length; s++) {
      var classes = stylesheets[s].rules || stylesheets[s].cssRules;
      for (var x = 0; x < classes.length; x++) {
        if(classes[x].selectorText != undefined) {
          var selectPosition = classes[x].selectorText.indexOf('select');
          var optionPosition = classes[x].selectorText.indexOf('option');
          var selectChar = classes[x].selectorText.charAt(selectPosition - 1);
          var optionChar = classes[x].selectorText.charAt(optionPosition - 1);
          if(selectPosition >= 0 && optionPosition >= 0 && (selectChar == '' || selectChar == '}' || selectChar == ' ') && (optionChar == '' || optionChar == '}' || optionChar == ' ')) {
            text = (classes[x].cssText) ? classes[x].cssText : classes[x].style.cssText;
            css += text.replace(/\boption\b/g, '[data-cuteselect-value]').replace(/\bselect\b/g, '[data-cuteselect-item]');
            continue;
          }
          if(selectPosition >= 0) {
            var character = classes[x].selectorText.charAt(selectPosition - 1);
            if(character == '' || character == '}' || character == ' ') {
              text = (classes[x].cssText) ? classes[x].cssText : classes[x].style.cssText;
              css += text.replace(/\bselect\b/g, '[data-cuteselect-item]');
            }
          }
          if(optionPosition >= 0) {
            var character = classes[x].selectorText.charAt(optionPosition - 1);
            if(character == '' || character == '}' || character == ' ') {
              text = (classes[x].cssText) ? classes[x].cssText : classes[x].style.cssText;
              css += text.replace(/\boption\b/g, '[data-cuteselect-value]');
            }
          }
        }
      }
    }

    return css;
  },
  createSelect: function(item) {

    // Create custom select
    var node = document.createElement("div");
    if(item.hasAttribute('id')) { // Catch ID
      node.setAttribute('id', item.getAttribute('id')); 
      item.removeAttribute('id');
    }
    if(item.hasAttribute('class')) { // Catch Class
      node.setAttribute('class', item.getAttribute('class')); 
      item.removeAttribute('class');
    }

    // Hide select
    item.style.display = 'none';

    // Get Default value (caption)
    var caption = null;
    var cells = item.getElementsByTagName('option'); 
    for (var i = 0; i < cells.length; i++) { 
      caption = cells[0].innerHTML;
      if(cells[i].hasAttribute('selected')) {
        caption = cells[i].innerHTML;
        break;
      }
    }

    // Get select options
    var options = '<div data-cuteselect-title>' + caption + '</div><div data-cuteselect-options><div data-cuteselect-options-container>';
    var cells = item.getElementsByTagName('option'); 
    for (var i = 0; i < cells.length; i++) { 
      if(cells[i].hasAttribute('disabled')) { continue; }
      if(cells[i].hasAttribute('class')) { var optionStyle = ' class="' + cells[i].getAttribute('class') + '"'; } else { var optionStyle = ''; }
      if(cells[i].hasAttribute('id')) { var optionId = ' id="' + cells[i].getAttribute('id') + '"'; } else { var optionId = ''; }
      if(cells[i].hasAttribute('selected')) { options += '<div data-cuteselect-value="' + cells[i].value + '" data-cuteselect-selected="true"' + optionStyle + optionId + '>' + cells[i].innerHTML + '</div>'; }
      else { options += '<div data-cuteselect-value="' + cells[i].value + '"' + optionStyle + optionId + '>' + cells[i].innerHTML + '</div>'; }
    }
    options += '</div></div>';

    // New select customization
    node.innerHTML = caption;
    node.setAttribute('data-cuteselect-item', CuteSelect.tools.uniqid());
    node.innerHTML = options; // Display options
    item.setAttribute('data-cuteselect-target', node.getAttribute('data-cuteselect-item'));
    item.parentNode.insertBefore(node, item.nextSibling);

    // Hide all options
    CuteSelect.tools.hideEverything();
  },
  show: function(item) {
    if(item.parentNode.hasAttribute('data-cuteselect-item')) { var source = item.parentNode.getAttribute('data-cuteselect-item'); }
    else { var source = item.getAttribute('data-cuteselect-item'); }
    var cells = document.getElementsByTagName('select');
    if(item.hasAttribute('data-cuteselect-title')) { 
      item = item.parentNode;
      var cells = item.getElementsByTagName('div');  
    }
    else { var cells = item.getElementsByTagName('div');  }
    for (var i = 0; i < cells.length; i++) {
      if(cells[i].hasAttribute('data-cuteselect-options')) {
        targetItem = cells[i];
        cells[i].style.display = 'block';
        setTimeout(function() { targetItem.style.opacity = '1'; }, 10);
        cells[i].style.position = 'absolute';
        cells[i].style.left = item.offsetLeft + 'px';
        cells[i].style.top = (item.offsetTop + item.offsetHeight) + 'px';
      }
    }

    item.focus();

    SOMETHINGOPEN = item.getAttribute('data-cuteselect-item');
  },
  selectOption: function(item) {
    var label = item.innerHTML;
    var value = item.getAttribute('data-cuteselect-value');
    var parent = item.parentNode.parentNode.parentNode;
    var target = parent.getAttribute('data-cuteselect-item');
    var cells = parent.getElementsByTagName('div');
    for (var i = 0; i < cells.length; i++) {
      if(cells[i].hasAttribute('data-cuteselect-title')) { cells[i].innerHTML = label; }
    }

    // Real select
    var cells = document.getElementsByTagName('select');
    for (var i = 0; i < cells.length; i++) {
      var source = cells[i].getAttribute('data-cuteselect-target');
      if(source == target) { cells[i].value = value; }
    }
    CuteSelect.tools.hideEverything();
  },
  writeStyles: function() {
    toWrite = '<style type="text/css">' + CuteSelect.tools.getStyle() + ' [data-cuteselect-options] { opacity: 0; display: none; }</style>';
    document.write(toWrite);
  }
};

CuteSelect.event = {
  parse: function() {
    var cells = document.getElementsByTagName('select'); 
    for (var i = 0; i < cells.length; i++) { CuteSelect.tools.createSelect(cells[i]); }
  },
  listen: function() {
    document.onkeydown = function(evt) {
      evt = evt || window.event;
      if (evt.keyCode == 27) { CuteSelect.tools.hideEverything(); }
    };
    document.onclick = function(event) {
      FIRSTLOAD = false; 
      if((!event.target.getAttribute('data-cuteselect-item') && !event.target.getAttribute('data-cuteselect-value') && !event.target.hasAttribute('data-cuteselect-title')) || ((event.target.hasAttribute('data-cuteselect-item') || event.target.hasAttribute('data-cuteselect-title')) && SOMETHINGOPEN)) { 
        CuteSelect.tools.hideEverything();
        return; 
      }
      var action = event.target;
      if(event.target.getAttribute('data-cuteselect-value')) {
        CuteSelect.tools.selectOption(action);
        CuteSelect.tools.hideEverything();
      } 
      else { CuteSelect.tools.show(action); }
      return false;
    }
  },
  manage: function() {
    if(CuteSelect.tools.canRun()) { // IE Compatibility
      CuteSelect.event.parse();
      CuteSelect.event.listen();
      CuteSelect.tools.writeStyles();
    }
  }
};

CuteSelect.event.manage();

})();
    </script>
</body>
</html>