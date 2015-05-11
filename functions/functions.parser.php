<?php

  function parser($text)
  {
    //$text = stripslashes($text); // On enlève les slashs qui se seraient ajoutés automatiquement
    $text = htmlspecialchars($text); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
    $text = nl2br($text); // On crée des <br /> pour conserver les retours à la ligne

    // On retire les mots clés
    $text = preg_replace('#\[\[(.+)\]\]#isU', '<a href="#">$1</a>', $text);

    $processed_tags = 0;


    $wtext = '';
    $wtag = '';
    while($processed_tags <2)
    {
      $i = 0;
      // Premier itérateur pour parcourir la chaîne entière
      for($i; $i < strlen($text); $i++)
      {
        if($text[$i] == '[')
        {
          // On commence le working tag
          $wtag .= $text[$i];

          // On va analyser dans le but de complèter le working tag et le traiter//
          for($j = $i+1; $j < strlen($text); $j++)
          {
            // Si on retombe sur un tag ouvrant; on sauve le tag supérieur et on reset le workign tag
            if($text[$j] == '[')
            {
              $wtext .= $wtag;
              $wtag = '';
              $wtag = $text[$j];
            }
            // Si balise fermante, on l'inclus et on parse, ensuite on recommence au dernier char lu
            else if($text[$j] == ']')
            {
              $wtag .= $text[$j];
              $wtag = parser_decode($wtag);
              $wtext .= $wtag;
              $wtag = '';
              $i = $j;
              break;
            }
            // Si non balise, on continue en ajoutant le char au workign tag
            else
            {
              $wtag .= $text[$j];
            }
          }
        }
        else
        {
          $wtext .= $text[$i];
        }
      }
      $processed_tags++;
      $text = $wtext;
      $wtext = '';
    }

    echo $text;
  }

  function form_test()
  {
    $value = 'lalalal[ul|un||d[b|eu]x|[ul|trois]|qu[s|atr]e [[mot]]]
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
              [img | http://www.spirou.com/boutique/client/cache/produit/384_____SPIST01701_431.jpg  | zorglub  ]
              [!| du commentaire]
              [p| Quelques retours..][n][n][p|à la ligne]
              [a| http://www.google.be | google.be]
              [a| http://www.google.be | google.be]
              [a| http://www.google.be | google.be]';

    $value2 = '[u|uuu[i|iii]bbb[i|iii] bbbb [i|iii]]';
    echo '<form name="testparse" action="index.php?page=wiki" method="post">
            <label> Votre texte : </label><br/>
            <textarea rows="6" cols="50" name="text"> ' . $value2 . '</textarea><br/>
            <input type="submit" name="submit"/>
          </form>';
  }

  function parser_decode($text)
  {
    $text = preg_replace('#\[b\|(.+)\]#isU', '<b>$1</b>', $text);
    $text = preg_replace('#\[u\|(.+)\]#isU', '<u>$1</u>', $text);
    $text = preg_replace('#\[i\|(.+)\]#isU', '<i>$1</i>', $text);

    return $text;
  }

?>
