Ce plugin symfony 1.4 fournit une liste de widgets et validateurs permettant d'agrémenter vos formulaires. La plupart de ces widgets utilisent [jQuery 1.6.1](http://jquery.com/) et [jQueryUI 1.8.13](http://jqueryui.com/).

# <a id="widgets"></a>Widgets

## <a id="sfWidgetFormInputFilemanager"></a>sfWidgetFormInputFilemanager
Affiche un gestionnaire de fichier permettant de déposer, supprimer ou sélectionner un fichier sur le serveur.

* path [string, optionnel, défaut: /uploads] : répertoire de dépôt des fichiers
* button_label [string, optionnel, défaut: Parcourir] : intitulé du bouton d'ouverture
* is_image [boolean, optionnel, défaut: false] : permet d'afficher l'image
* width [integer, optionnel, défaut: 900] : largeur de la fenêtre
* height [integer, optionnel, défaut: 500] : hauteur de la fenêtre
* returnFunction [string, optionnel, défaut: null] : fonction de retour pour un éventuel traitement de la donnée

## <a id="sfWidgetFormInputUploadify"></a>sfWidgetFormInputUploadify
Affiche un [uploadify](http://www.uploadify.com/) permettant de gérer un ou plusieurs fichiers selon son poids, son extension, etc... Retourne le chemin du fichier, par exemple : /uploads/assets/monFichier.jpg.

* url [string, optionnel, défaut: /sfEPFactoryForm/uploadify] : url du script de dépôt du fichier
* path [string, optionnel, défaut: /uploads] : répertoire de destination
* buttonText [string, optionnel, défaut: Parcourir...] : intitulé du bouton d'ouverture
* checkScript [string, optionnel, défaut: null] : script de vérification des fichiers existants
* fileExt [string, optionnel, défaut: null] : extensions autorisées
* fileDesc [string, optionnel, défaut: null] : description si l'option _fileExt_ est renseignée
* is_image [boolean, optionnel, défaut: false] : affiche l'image depuis le fichier
* multi [boolean, optionnel, défaut: false] : permet la gestion de plusieurs fichiers en même temps (retourne une chaîne dont les noms de fichiers sont séparés par une virgule)
* max [integer, optionnel, défaut: 999] : nombre maximum de fichier à déposer en même temps
* scriptData [array, optionnel, défaut: null] : données complémentaires à envoyer au script de dépôt du fichier. Le paramètre _folder_, correspondant au paramètre _path_, est ajouté à ce tableau lors de l'envoi
* sizeLimit [integer, optionnel, défaut: null] : taille maximale en bytes des fichiers
* addScript [boolean, optionnel, défaut: true] : insert le javascript avec le widget. Utilisez _false_ dans le cas de l'utilisateur du widget sfWidgetFormMultiple, par exemple
* editable [boolean, optionnel, défaut: true] : permet de supprimer les fichiers existants
* fullMessage [string, optionnel, défaut: Vous ne pouvez uploader que %%max%% fichiers maximum.] : message en cas de queue pleine
* errorMessage [string, optionnel, défaut: Une erreur est survenue.] : message en cas d'erreur
* alertFunction [string, optionnel, défaut: alert] : fonction javascript permettant de rendre les messages d'erreur

## <a id="sfWidgetFormInputCkeditor"></a>sfWidgetFormInputCkeditor
Affiche un WYSIWYG (What You See Is What You Get) basé sur [CKEditor](http://ckeditor.com/).

* width [integer, optionnel, défaut: 635] : largeur du champ
* height [integer, optionnel, défaut: 400] : hauteur du champ
* filemanager_path [string, optionnel, défaut: /uploads] : répertoire utilisé pour le gestionnaire de fichiers
* toolbar [string, optionnel, défaut: Custom] : barre d'outils CKEditor utilisée. Consultez la [documentation de CKEDITOR](http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar) pour plus d'informations

## <a id="sfWidgetFormInputMask"></a>sfWidgetFormInputMask
Affiche un champ avec un masque javascript.

* mask [string, requis] : masque javascript. Consultez la [documentation](http://digitalbush.com/projects/masked-input-plugin/) pour plus d'informations
* formatter [callback, optionnel, défaut: null] : fonction de formatage de la valeur

## <a id="sfWidgetFormInputPlain"></a>sfWidgetFormInputPlain
Affiche la valeur du champ sans afficher le champ de formulaire (input:hidden). Si la valeur est un format date ou timestamp, il est automatiquement converti en format date français pour l'affichage.

* value [string, optionnel, défaut: null] : permet de forcer la valeur affichée

## <a id="sfWidgetFormInputStarEvaluation"></a>sfWidgetFormInputStarEvaluation
Affiche une série d'étoiles permettant de donner une note.

* max [integer, requis] : nombre maximum d'étoiles à afficher
* size [integer, optionnel, défaut: 16] : taille des étoiles

## <a id="sfWidgetFormInputSwitch"></a>sfWidgetFormInputSwitch
Affiche un bouton de type "on/off" pour gérer une valeur booléenne. Ce widget étend [sfWidgetFormSelectRadio](http://www.symfony-project.org/api/1_4/sfWidgetFormSelectRadio).

## <a id="sfWidgetFormKeyboard"></a>sfWidgetFormKeyboard
Affiche un clavier virtuel permettant la saisie du champ (textarea, input:text, etc...).

* layout [string, optionnel, défaut: arabic-azerty] : thème utilisé pour le clavier. Vous pouvez créer un nouveau thème de clavier en créant un nouveau fichier dans le répertoire _/sfEPFactoryPlugin/jquery-keyboard/layouts_. Ce fichier doit être nommé par le nom du layout (exemple : _custom_ deviendra _/sfEPFactoryPlugin/jquery-keyboard/layouts/custom.js_).
* maxLength [integer, optionnel, défaut: false] : taille maximale du champ de saisie
* renderer_class [string, optionnel, défaut: sfWidgetFormInputText] : widget utilisé pour le champ de saisie
* renderer_options [array, optionnel, défaut: array()] : options du widget de rendu
* url [string, optionnel, défaut: null] : si renseigné, le champ de saisi propose une autocomplétion
* multi [boolean, optionnel, défaut: false] : si le paramètre _url_ est renseigné, autorise la saisie de plusieurs champs avec l'autocomplétion. le séparateur utilisé est la virgule.
* caching [boolean, optionnel, défaut: true] : si le paramètre _url_ est renseigné, met en cache les résultats
* theme [string, optionnel, défaut: /sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css] : thème jQuery

## <a id="sfWidgetFormSelectSlider"></a>sfWidgetFormSelectSlider
Affiche un [slider jQuery](http://docs.jquery.com/UI/Slider). Ce widget étend [sfWidgetFormSelect](http://www.symfony-project.org/api/1_4/sfWidgetFormSelect).

* theme [string, optionnel, défaut: /sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css] : thème jQuery

## <a id="sfWidgetFormMultiple"></a>sfWidgetFormMultiple
Affiche une zone comprenant plusieurs champs de formulaire. Ce widget est utile pour l'édition de relations multiples. Il propose une interface javascript permettant d'ajouter/supprimer dynamiquement des éléments.

Il est recommandé d'utiliser le validateur [sfValidatorMultiple](#sfValidatorMultiple).

* widgets [array, requis] : tableau des widgets symfony
* createLabel [string, optionnel, défaut: Créer] : intitulé du bouton de création
* max [integer, optionnel, défaut: null] : nombre maximum de valeurs autorisées
* min [integer, optionnel, défaut: null] : nombre minimum de valeurs requises
* onAdd [string, optionnel, défaut: null] : code javascript à exécuter lors d'un ajout. les paramètres _event_ et _object_ sont envoyés, correspondant respectivement à l'événement et le nouvel objet créé
* onRemove [string, optionnel, défaut: null] : code javascript à exécuter lors d'une suppression. les paramètres _event_ et _object_ sont envoyés, correspondant respectivement à l'événement et l'objet supprimé

## <a id="sfWidgetFormInputDate"></a>sfWidgetFormInputDate
Affiche un champ de saisi avec un masque javascript sur un format date français. Ce widget étend [sfWidgetFormInputMask](#sfWidgetFormInputMask).

Il est recommandé d'utiliser le validateur [sfValidatorDateCustom](#sfValidatorDateCustom).

## <a id="sfWidgetFormDateJQueryUI"></a>sfWidgetFormDateJQueryUI
Affiche un calendrier jQuery pour l'édition d'une date.

Pour un format français (dd/mm/yyyy), il est recommandé d'utiliser le validateur [sfValidatorDateCustom](#sfValidatorDateCustom).

* culture [string, optionnel, défaut: fr] : langue de l'utilisateur
* change_month [boolean, optionnel, défaut: false] : permet de changer les mois
* change_year [boolean, optionnel, défaut: false] : permet de changer l'année
* number_of_month [integer, optionnel, défaut: 1] : nombre de mois affichés en même temps
* show_button_panel [boolean, optionnel, défaut: false] : affiche les boutons d'actions rapides "aujourd'hui" et "ok"
* show_previous_dates [boolean, optionnel, défaut: true] : affiches les dates passées
* inline [boolean, optionnel, défaut: false] : affiche le calendrier uniquement, ou le champ input
* theme [string, optionnel, défaut: /sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css] : thème jQuery

## <a id="sfWidgetFormTimestamp"></a>sfWidgetFormTimestamp
Affiche un calendrier jQuery pour l'édition d'une date, combiné avec 2 sliders jQuery pour l'édition de l'heure et les minutes. Ce widget étend [sfWidgetFormDateJQueryUI](#sfWidgetFormDateJQueryUI).

* stepHour [integer, optionnel, défaut: 1] : pas d'incrémentation du slider des heures
* stepMinute [integer, optionnel, défaut: 1] : pas d'incrémentation du slider des minutes

## <a id="sfWidgetFormInputAutocomplete"></a>sfWidgetFormInputAutocomplete
Affiche un champ de saisie avec autocomplétion.

* url [string, requis] : url de recherche
* multiple [boolean, optionnel, défaut: false] : permet une autocomplétion multiple, les champs sont séparés par une virgule
* caching [boolean, optionnel, défaut: false] : conserve les résultats en cache
* theme [string, optionnel, défaut: /sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css] : thème jQuery

## <a id="sfWidgetFormInputDoctrineAutocomplete"></a>sfWidgetFormInputDoctrineAutocomplete
Affiche un champ de saisie avec autocomplétion basé sur un objet Doctrine. Ce widget étend [sfWidgetFormInputAutocomplete](#sfWidgetFormInputAutocomplete).

Il est recommandé d'utiliser le validateur [sfValidatorDoctrineAutocomplete](#sfValidatorDoctrineAutocomplete)

* model [string, requis] : classe de l'objet Doctrine
* column [string, optionnel, défaut: null] : colonne de recherche. utilise la clé primaire par défaut
* query [Doctrine_Query, optionnel, défaut: null] : objet Doctrine_Query de recherche
* render [string, optionnel, défaut: __toString] : méthode utilisée pour rendre l'objet

## <a id="sfWidgetFormInputToken"></a>sfWidgetFormInputToken
Affiche un champ de saisie avec autocomplétion type "facebook" ([exemples](http://loopj.com/jquery-tokeninput/)) : les valeurs sont séparées par une virgule, avec un thème ergonomique permettant leur suppression en javascript.

Ce widget retourne une chaîne dont les valeurs sont séparées par une virgule.

* url [string, requis] : url de recherche


# <a id="validators"></a>Validateurs

## <a id="sfValidatorTimestamp"></a>sfValidatorTimestamp
Permet la validation d'un temps au format français (dd/mm/yyyy hhHii). Ce validateur étend [sfValidatorDateTime](http://www.symfony-project.org/api/1_4/sfValidatorDateTime).

Ce validateur est utile pour l'utilisation du widget [sfWidgetFormTimestamp](#sfWidgetFormTimestamp).

## <a id="sfValidatorDateCustom"></a>sfValidatorDateCustom
Permet la validation d'une date au format français (dd/mm/yyyy). Ce validateur étend [sfValidatorDate](http://www.symfony-project.org/api/1_4/sfValidatorDate).

Ce validateur est utile pour l'utilisation des widgets [sfWidgetFormDateJQueryUI](#sfWidgetFormDateJQueryUI) et [sfWidgetFormInputDate](#sfWidgetFormInputDate).

## <a id="sfValidatorHourCustom"></a>sfValidatorHourCustom
Permet la validation d'un temps en heures (hhHii). Ce validateur étend [sfValidatorTime](http://www.symfony-project.org/api/1_4/sfValidatorTime).

Ce validateur est utile pour l'utilisation du widget [sfWidgetFormInputMask](#sfWidgetFormInputMask) dans le cadre d'un masque d'heures _99h99_.

## <a id="sfValidatorDoctrineAutocomplete"></a>sfValidatorDoctrineAutocomplete
Permet la validation d'un champ d'autocomplétion Doctrine. Ce validateur est utilisé avec les widgets [sfWidgetFormDoctrineAutocomplete](Widgets) ou [sfWidgetFormInputToken](#sfWidgetFormDoctrineAutocomplete](Widgets) ou [sfWidgetFormInputToken).

* model [string, requis] : classe Doctrine de l'objet de recherche
* query [Doctrine_Query, optionnel, défaut: null] : objet Doctrine_Query de recherche
* column [string, optionnel, défaut: null] : colonne de recherche. utilise la clé primaire par défaut
* return_column [string, optionnel, défaut: null] : colonne utilisée pour la valeur de retour. utilise la clé primaire par défaut
* multiple [boolean, optionnel, défaut: false] : autorise plusieurs valeurs. utile lors de l'utilisation du widget [sfWidgetFormInputToken](#boolean, optionnel, défaut: false] : autorise plusieurs valeurs. utile lors de l'utilisation du widget [sfWidgetFormInputToken)
* autosave [boolean, optionnel, défaut: false] : si l'enregistrement n'existe pas, il est automatiquement créé dans la base

## <a id="sfValidatorUrlCustom"></a>sfValidatorUrlCustom
Permet la validation d'une adresse web. Ce validateur autorise les adresses web (http, https, ftp, ftps), les adresses internes (/mon-adresse), et les routes symfony (@ma_route, module/action).

* allow_symfony_routes [boolean, optionnel, défaut: false] : autorise les routes symfony (@ma_route, module/action). si le paramètre est à false, un / est ajouté au début de la valeur
* allow_external_routes [boolean, optionnel, défaut: false] : autorise les adresses web (http, https, ftp, ftps). si le paramètre est à false, un / est ajouté au début de la valeur
* protocols [array, optionnel, défaut: array(http, https, ftp, ftps)] : liste des protocols autorisés pour les adresses web

## <a id="sfValidatorMultiple"></a>sfValidatorMultiple
Permet la validation de valeurs multiples. Ce validateur est utilisé avec le widget [sfWidgetFormMultiple](#sfWidgetFormMultiple).

* validators [array, requis] : liste des validateurs symfony
