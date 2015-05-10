<?php

  function parser($text)
  {
    //preg_quote(DIRECTORY_SEPARATOR, '#');

    $text = stripslashes($text); // On enlève les slashs qui se seraient ajoutés automatiquement
    $text = htmlspecialchars($text); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
    $text = nl2br($text); // On crée des <br /> pour conserver les retours à la ligne

    /**************
    * SIMPLE TAGS *
    ***************/

    // TITLES TEXT
    $text = preg_replace('#\[([1-4])\|(.+)\]#isU', '<h$1>$2</h$1>', $text);
    // DIVS TAGS
    $text = preg_replace('#\[d\|(.+)\]#isU' '<div>$1</div>', $text);
    // BOLD TEXT
    $text = preg_replace('#\[b\|(.+)\]#isU', '<b>$1</b>', $text);
    // ITALIC TEXT
    $text = preg_replace('#\[i\|(.+)\]#isU', '<i>$1</i>', $text);
    // UNDERLINED TEXT
    $text = preg_replace('#\[u\|(.+)\]#isU', '<u>$1</u>', $text);

    echo $text . '<br />';
  }

  function form_test()
  {
    $value = '[ul|un||d[b|eu]x|[ul|trois]|qu[s|atr]e [[mot]]]
              [bg|#dfd|avant[ol|a1|b2]après]
              [div|#ddf|
              [ol_|i|-5|x|y|z]
              ]
              [div|	http://www.webweaver.nu/clipart/img/web/backgrounds/halloween/ghosts.gif |
              [#ff0|[ol_|a|0|[ol|a1|[#fff|b2]]|[ul|1|2|3]|z]]
              ]
              \'"&<> \[\]\^\|
              rien[[premier mot]] [b|gras] [[deuxième]][h][bg|#dfd|toto]
              [u|souligné] [[troisième]][n]truc [i|ita[#F0F|lique]]
              [b|bbb[u|uuu[i|iii]bbb[[quatri ème]]bb]]
              [ a| ici |lien ]
              [img | http://www.spirou.com/boutique/client/cache/produit/384_____SPIST01701_431.jpg  | zorglub  ]';
    echo '<form name="testparse" action="index.php?page=wiki" method="post">
            <label> Votre texte : </label><br/>
            <textarea rows="6" cols="50" name="text"> ' . $value . '</textarea><br/>
            <input type="submit" name="submit"/>
          </form>';
  }

?>
