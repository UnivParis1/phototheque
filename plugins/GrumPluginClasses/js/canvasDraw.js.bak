/** ----------------------------------------------------------------------------
 * file         : CanvasDraw.js
 * file version : 1.0
 * date         : 2010-11-08
 * -----------------------------------------------------------------------------
 * author: grum at grum.fr
 * << May the Little SpaceFrog be with you >>
 *
 * This program is free software and is published under the terms of the GNU GPL
 * Please read CanvasDraw.ReadMe.txt file for more information
 *
 * -----------------------------------------------------------------------------
 *
 * Main program for canvas draw
 *
 * -----------------------------------------------------------------------------
 *
 * dependencies :
 *
 * -----------------------------------------------------------------------------
 *
 * provided classes :
 *
 * -----------------------------------------------------------------------------
 */

var langKeys={
      'Area size: %sx%spx'          : 'Dimensions de la fenêtre : %sx%spx',
      'Working sheet size: %sx%spx' : 'Dimensions de la feuille de travail : %sx%spx',
      'Show/Hide console'           : 'Afficher/Masquer la console',
      'Cursor position'             : 'Position',
      'Picture size'                : 'Dimensions de la photo',
      'Zoom factor'                 : 'Zoom',

      'Tools'                       : 'Outils',
      'Objects'                     : 'Objets',
      'Properties'                  : 'Propriétés',
      'Colors'                      : 'Couleurs',
      'Styles'                      : 'Styles',
      'Options'                     : 'Options',

      'Colors, gradients and patterns' : 'Couleurs, dégradés et motifs',

      'There\'s no item selected'   : 'Aucun élément n\'est sélectionné',
      'There\'s no item selected to rotate' : 'Impossible d\'effectuer une rotation, il n\' y a aucun élément de sélectionné',
      'There\'s no item selected to translate' : 'Impossible d\'effectuer une translation, il n\' y a aucun élément de sélectionné',
      'There\'s no item selected to scale' : 'Impossible d\'effectuer une mise à l\'échelle, il n\' y a aucun élément de sélectionné',
      'There\'s no item selected to set properties' : 'Impossible d\'effectuer une mise à jour des propriétés, il n\' y a aucun élément de sélectionné',
      'Unknown object id'           : 'Identifiant inconnu',
      'Selected:'                   : 'Sélectionné : ',
      'group'                       : 'groupe',
      'shape'                       : 'forme',
      'picture'                     : 'image',
      'text'                        : 'texte',

      // technical
      '<exec.ok>'                   : 'OK',
      '<exec.error>'                : 'Erreur : ',
      '<exec.return>'               : '# ',
      '<prompt commands>'           : 'Commandes du prompt : option, select, properties',

      // error messages
      'error-1_1'                   : 'Commande inconnue',
      'error-1_2'                   : 'Nombre de paramètres incorrect',
      'error-1_3'                   : 'Aucune commande ?',
      'error-1_4'                   : 'Paramètres invalides',
      'error-2_1'                   : 'Interpreteur non initialisé'
    };

function _(key)
{
  var value=key,
      re=/(%s)+/;

  if(langKeys[key]!=null)
  {
    value=langKeys[key];
  }

  p=1;
  while(re.exec(value)!=null && p<=arguments.length)
  {
   value=value.replace(re, arguments[p++]);
  }

  return(value);
}



function CanvasDraw ()
{
  var privateMethods=
  {
    open : function (imageUrl)
      {
      } //open
  };


  /*
   * public methods
   */
  this.open = function (imageUrl)
    {
      privateMethods.open(imageUrl);
    }; //this.open

} // canvas draw
