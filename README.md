treeoflife-php
==============

### PHP Class that generates a Qabbalistic Tree of Life using HTML5 and CSS

Documentation is coming soon...

## How to use

*This documentation is still being made*

### Including the class

Include the file tree.php in your PHP project,

    <?php
    include "tree.php";
    ?>

### Creating the Object

Then create an object with

    <?php
      $width = 650;
      $tree = new TreeOflife($width);
    ?>

Here, $width is the width of the Tree in pixels.

### Then, outputting the tree

#### CSS

Inside the <head> of your html, you output the css, with

    <?php echo $tree->htmlandcss->css; ?>

It will inclyde the <style> tag

#### HTML elements

Then, to include the HTML elements of the tree, we can use

    echo $tree->htmlandcss->html;

