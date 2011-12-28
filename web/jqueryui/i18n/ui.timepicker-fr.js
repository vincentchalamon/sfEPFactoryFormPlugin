/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood@virginbroadband.com.au) and Stéphane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.timepicker.regional['fr'] = {
      timeOnlyTitle: "Saisie d'un temps",
      timeText: 'Temps',
      hourText: 'Heures',
      minuteText: 'Minutes',
      secondText: 'Secondes',
      currentText: 'Maintenant',
      closeText: 'Fermer',
      ampm: false
    };
	$.timepicker.setDefaults($.timepicker.regional['fr']);
});