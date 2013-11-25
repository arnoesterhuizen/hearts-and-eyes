(function() {
   tinymce.create('tinymce.plugins.people', {
      init : function(ed, url) {
         ed.addButton('people', {
            title : 'People',
            image : url+'/person.png',
            onclick : function() {
               var person = prompt("Name of Person", "");

							if (person != null && person != '')
								 ed.execCommand('mceInsertContent', false, '[person]'+text+'[/person]');
							else
								 ed.execCommand('mceInsertContent', false, '[person][/person]');
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "People",
            author : 'Arno Esterhuizen',
            authorurl : 'http://',
            infourl : 'http://',
            version : "1.0"
         };
      }
   });
   
   tinymce.create('tinymce.plugins.productions', {
      init : function(ed, url) {
         ed.addButton('productions', {
            title : 'Productions',
            image : url+'/production.png',
            onclick : function() {
               var production = prompt("Name of Production", "");

							if (production != null && production != '')
								 ed.execCommand('mceInsertContent', false, '[production]'+text+'[/production]');
							else
								 ed.execCommand('mceInsertContent', false, '[production][/production]');
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Productions",
            author : 'Arno Esterhuizen',
            authorurl : 'http://',
            infourl : 'http://',
            version : "1.0"
         };
      }
   });
   
   tinymce.PluginManager.add('people', tinymce.plugins.people);
   tinymce.PluginManager.add('productions', tinymce.plugins.productions);
})();