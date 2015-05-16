<?php

  function parser($text, $subject)
  {
    // Replacing special chars by html code
    //$text = htmlspecialchars($text);

    // Creating <br/> to keep carriage returns
    $text = nl2br($text);

    $text = preg_replace_callback(
      '#\[\[(.+)\]\]#isU',
      function($match) use ($subject)
      {
        if(keyword_exists($subject, $match[1]))
        {
          return '<a class="validkeyword" href="index.php?page=subject&subjectid='. $subject->getId() .'&action=displaypage&pageid='. get_page_value('id', 'keyword', $match[1]) .'">' . $match[1] . '</a>';
        }
        else
        {
          return '<a class="createkeyword" href="index.php?page=subject&subjectid='. $subject->getId() .'&action=createpage&keyword='. $match[1] .'">' . $match[1] . '</a>';
        }
      },
      $text
    );

    // Boolean value used by whole function to exit loop when no tag is processed
    $processed_tags = true;


    $wtext = '';
    $wtag = '';
    while($processed_tags)
    {
      $i = 0;
      $processed_tags = false;
      // Premier itérateur pour parcourir la chaîne entière
      for($i; $i < strlen($text); $i++)
      {
        if($i == 0 AND $text[$i] == '\\')
        {
          $wtext .= $text[$i];
        }
        else if($text[$i] == '[' AND ($i == 0 OR $text[$i-1] != '\\'))
        {
          // On commence le working tag
          $wtag .= $text[$i];

          // On va analyser dans le but de complèter le working tag et le traiter//
          for($j = $i+1; $j < strlen($text); $j++)
          {
            // Si on retombe sur un tag ouvrant; on sauve le tag supérieur et on reset le workign tag
            if($text[$j] == '[' AND $text[$j-1] != '\\')
            {
              $wtext .= $wtag;
              $wtag = '';
              $wtag = $text[$j];
            }
            // Si balise fermante, on l'inclus et on parse, ensuite on recommence au dernier char lu
            else if($text[$j] == ']' AND $text[$j-1] != '\\')
            {
              $wtag .= $text[$j];
              $wtag = parser_decode($wtag);
              $wtext .= $wtag;
              $wtag = '';
              $i = $j;
              $processed_tags = true;
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
      $text = $wtext;
      $wtext = '';
    }
    return parser_specialchars($text);
  }

  function parser_decode($text)
  {
    /****************
    * SPECIAL CHARS *
    *****************/
    // On retire les fausses balises
    $text = preg_replace('#\[[^abipuhndtb1234]\|(.[^\]]+)\]#', '$1', $text);

    /**************
    * SIMPLE TAGS *
    ***************/
    // COMMENTS
    $text = preg_replace('#\[\!\|(.+)\]#isU', '<!--$1-->', $text);
    // TITLES
    $text = preg_replace('#\[1\|(.+)\]#isU', '<h1>$1</h1>', $text);
    $text = preg_replace('#\[2\|(.+)\]#isU', '<h2>$1</h2>', $text);
    $text = preg_replace('#\[3\|(.+)\]#isU', '<h3>$1</h3>', $text);
    $text = preg_replace('#\[4\|(.+)\]#isU', '<h4>$1</h4>', $text);
    // DIVS
    $text = preg_replace('#\[d\|(.+)\]#isU', '<div>$1</div>', $text);
    // PARAGRAPHS
    $text = preg_replace('#\[p\|(.+)\]#isU', '<p>$1</p>', $text);
    // BR TAG
    $text = preg_replace('#\[n\]#isU', '<br/>', $text);
    // HORIZONTAL ROW
    $text = preg_replace('#\[h\]#isU', '<hr/>', $text);
    // BOLD
    $text = preg_replace('#\[b\|(.+)\]#isU', '<b>$1</b>', $text);
    // ITALIC
    $text = preg_replace('#\[u\|(.+)\]#isU', '<u>$1</u>', $text);
    // UNDERLINED
    $text = preg_replace('#\[i\|(.+)\]#isU', '<i>$1</i>', $text);

    /**************
    * TABLES TAGS *
    ***************/
    // TABLE
    // [tb||] - [tr] - [th] - [td]
    $text = preg_replace('#\[tb\|(.+)\|(.+)\]#isU', '<table style="border : solid gray $1px;">$2</table>', $text);
    $text = preg_replace('#\[tr\|(.+)\]#isU', '<tr>$1</tr>', $text);
    $text = preg_replace('#\[th\|(.+)\]#isU', '<th>$1</th>', $text);
    $text = preg_replace('#\[td\|(.+)\]#isU', '<td>$1</td>', $text);

    /***************
    * COMPLEX TAGS *
    ****************/
    // URL
    $text = preg_replace('#\[\s?a\s?\|\s?(.+)\s?\|\s?(.+)\s?\]#isU', '<a href="$1">$2</a>', $text);
    // IMAGE
    $text = preg_replace('#\[img\s?\|\s?(.+)\s?\|\s?(.+)\s?\]#isU', '<img src="$1" alt="$2"/>', $text);
    // SPECIAL OLS
    $text = preg_replace('#\[ol_\|(.+)\|(.+)\|(.+)\]#isU', '<ol type="$1" start="$2"><li>$3</li></ol>', $text);
    // NORMAL ULS
    $text = preg_replace('#\[ul\|(.*)\]#isU', '<ul><li>$1</li></ul>', $text);
    // NORMAL OLS
    $text = preg_replace('#\[ol\|(.*)\]#isU', '<ol><li>$1</li></ol>', $text);
    // COLORED TEXT SPANS
    $text = preg_replace('#\[\#(.+)\|(.+)\]#isU', '<span style="color:#$1;">$2</span>', $text);
    // COLORED BACKGROUNDED SPANS
    $text = preg_replace('#\[bg\|\#(.+)\|(.+)\]#isU', '<span style="background : #$1">$2</span>', $text);
    // COLORED BACKGROUNDED DIVS
    $text = preg_replace('#\[div\|\#(.+)\|(.+)\]#isU', '<div style="background : #$1">$2</div>', $text);
    // IMAGE BACKGROUNDED DIVS
    $text = preg_replace('#\[div\|(.+)\|(.+)\]#isU', '<div style="background : url($1);">$2</div>', $text);
    // CREATING LIST ITEMS
    $text = preg_replace('#(\|)#isU', '</li><li>', $text);

    return $text;
  }

  function parser_specialchars($text)
  {
    // Replace \char by the wanted special char
    $text = preg_replace('#\\\\(.{1})#isU', '$1', $text);
    // Replace ^ by a blank space
    $text = preg_replace('#^#isU', '&nbsp;', $text);
    return $text;
  }

  function form_test()
  {
    $text_test = 'lalalal[ul|un||d[b|eu]x|[ul|trois]|qu[s|atr]e [[mot]]]
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

    $table = '[tb|1|[tr|[td|lol][td|lol]][tr|[td|mdr][td|mdl][td|[ul|groschichon|lelele|[ol|lele|remy|es†|tropur]]]]]';
    echo '<form name="testparse" action="index.php?page=wiki" method="post">
            <label> Votre texte : </label><br/>
            <textarea rows="6" cols="50" name="text">' . $text_test . '</textarea><br/>
            <input type="submit" name="submit"/>
          </form>';
  }
?>
