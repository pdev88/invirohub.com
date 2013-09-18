/*
 * jQuery News Viewer Plugin for WYSIWYG Web Builder v7.5
 * Copyright Pablo Software solutions 2010
 * http://www.wysiwygwebbuilder.com/
 *
 */

(function($)
{
   $.fn.newsviewer = function(options) 
   {
      return this.each(function() 
      {   
         $.newsviewer(this, options);
      });
   };

   $.newsviewer = function(obj, options) 
   {
      var settings = 
      {
         mode: 'default', 
         dataSource: 'local',
         param: null,
         url: null,
         maxItems: 10,
         pause: 5000,
         includeDate: true,
         numPerPage: 1
      };

      if (options)
         settings = $.extend(settings, options);

      $obj = $(obj);
      $obj.empty();      

      if (settings.mode == 'scroller')
      {
         $('<p></p>').css('position', 'relative').appendTo($obj);
      }

      $container = $obj;

      if (settings.mode == 'scroller')
      {
         $container = $('p', $obj);
      }

      if (settings.dataSource == 'local')
      {
         if (settings.param != null)
         {
            for (var i=0; i<settings.param.length; i++)
            {
               AddHeadline($container, settings.param[i][0], settings.param[i][1], settings.param[i][2], settings.param[i][3], settings.includeDate);
            }
         }
         SetupViewer($obj, settings);
      }
      else 
      if (settings.dataSource == 'rss')
      {
         var $loadingIndicator = $('<img/>')
           .attr({
           'src': 'wb.newsviewer.gif', 
           'alt': 'Loading. Please wait.'
         })
         .addClass('news-wait')
         .appendTo($obj);

         $.get(settings.url, function(data) 
         {
            $loadingIndicator.remove();

            $('rss item', data).each(function(index, value) 
            {
               if (index >= settings.maxItems) 
                  return false;

               AddHeadline($container, $('link', this).text(), $('title', this).text(), $('pubDate', this).text(), $('description', this).text(), settings.includeDate);
            });
            SetupViewer($obj, settings);
        });
      }
      else 
      if (settings.dataSource == 'twitter')
      {
         var $loadingIndicator = $('<img/>')
           .attr({
           'src': 'wb.newsviewer.gif', 
           'alt': 'Loading. Please wait.'
         })
         .addClass('news-wait')
         .appendTo($obj);

         var url = "http://twitter.com/status/user_timeline/";
         url += settings.param;
	 url += ".json?count=";
         url += settings.maxItems;
	 url += "&callback=?";

         $.getJSON(url, function(data)
         {
            $loadingIndicator.remove();

            $.each(data, function(index, item) 
            {   
               var $link = $('<a></a>')
               .attr('href', 'http://twitter.com/' + settings.param)
               .text(item.text.substring(0, 25) + "...");

               var $headline = $('<h4></h4>').append($link);
               var $publication;
 
               if (settings.includeDate)
               {
                  $publication = $('<div></div>')
                     .addClass('publication-date')
                     .text(item.created_at);
               }
               else
               {
                  $publication = $('<div></div>');
               }

               var $summary = $('<div></div>')
               .addClass('summary')
               .text(item.text);
        
               $('<div></div>')
               .addClass('headline')
               .append($headline, $publication, $summary)
               .appendTo($container);

               $('<br>').appendTo($container);
            }); 
            SetupViewer($obj, settings);  
         });
      }
      else 
      if (settings.dataSource == 'flickr')
      {
         var $loadingIndicator = $('<img/>')
           .attr({
           'src': 'wb.newsviewer.gif', 
           'alt': 'Loading. Please wait.'
         })
         .addClass('news-wait')
         .appendTo($obj);

         var url = "http://api.flickr.com/services/feeds/photos_public.gne?format=json&";

         if (settings.param != null)
         {
            url += settings.param;
            url += "&";
         }

         url += "jsoncallback=?";

         $.getJSON(url, function(data)
         {
            $loadingIndicator.remove();

            $.each(data.items, function(index, item)
            {
               var $link = $('<a></a>')
               .attr('href', item.link)
               .text(item.title);

               var $headline = $('<h4></h4>').append($link);
               var $author = $('<div></div>')
                     .addClass('publication-date')
                     .text(item.author.split("(")[1].replace(")", ""));
    
               var $img = $('<img>').attr("src", item.media.m);
        
               $('<div></div>')
                  .addClass('headline')
                  .append($headline, $author, $img)
                  .appendTo($container);

               $('<br>').appendTo($container);

               if (index == settings.maxItems) 
                  return false;
            });
            SetupViewer($obj, settings);  
         });
      }
   }

   function AddHeadline($obj, url, title, date, description, includeDate)
   {
      var $link = $('<a></a>')
         .attr('href', url)
         .html(title);
      var $headline = $('<h4></h4>').append($link);
      var $publication;

      if (includeDate)
      {
         var pubDate = new Date(date);
         var pubMonth = pubDate.getMonth() + 1;
         var pubDay = pubDate.getDate(); 
         var pubYear = pubDate.getFullYear();

         if (!isNaN(pubMonth) && !isNaN(pubDay) && !isNaN(pubYear)) 
         {
            $publication = $('<div></div>')
               .addClass('publication-date')
               .text(pubMonth + '/' + pubDay + '/' + pubYear);
         }
         else
         {
            $publication = $('<div></div>');
         }
      }
      else
      {
         $publication = $('<div></div>');
      }

      var $summary = $('<div></div>')
          .addClass('summary')
          .html(description);
        
      $('<div></div>')
          .addClass('headline')
          .append($headline, $publication, $summary)
          .appendTo($obj);

      $('<br>').appendTo($obj);
   }
  
   function SetupViewer($obj, settings)
   {
      if (settings.mode == 'default')
      {
         $obj.css('overflow-y', 'auto'); 

         $('.headline').css('position', 'relative');
         $('.headline').css('height', 'auto');
         $('.headline').css('top', '0');
      }
      else
      if (settings.mode == 'rotate')
      {
         var currentHeadline = 0, oldHeadline = 0;
         var hiddenPosition = $obj.height() + 10;
         $('div.headline').eq(currentHeadline).css('top', 0);
         var headlineCount = $('div.headline').length;
         var pause;
         var rotateInProgress = false;

         var headlineRotate = function() 
         {
            if (!rotateInProgress) 
            {
               rotateInProgress = true;
               pause = false;
               currentHeadline = (oldHeadline + 1) % headlineCount;
            
               $('div.headline').eq(oldHeadline).animate(
               {top: -hiddenPosition}, 'slow', function() {
                 $(this).css('top', hiddenPosition);
               });
          
               $('div.headline').eq(currentHeadline).animate(
               { top: 0}, 'slow', function() {
                  rotateInProgress = false;
                  if (!pause) 
                  {
                     pause = setTimeout(headlineRotate, settings.pause);
                  }
               });
               oldHeadline = currentHeadline;
            }
         };
         if (!pause) 
         {
            pause = setTimeout(headlineRotate, settings.pause);
         }
      
         $obj.hover(function() 
         {
            clearTimeout(pause);
            pause = false;
         }, function() 
         {
            if (!pause) 
            {
               pause = setTimeout(headlineRotate, 250);
            }
         });
      }
      else
      if (settings.mode == 'scroller')
      {
         $('.headline').css('position', 'relative');
         $('.headline').css('height', 'auto');
         $('.headline').css('top', '0');

         settings.ticker_height = $obj.height();
         settings.news_height = $container.height();
         settings.line_count = 0;
         settings.rotate = true;

         $obj.hover(function()
         {
            settings.rotate = false;
         },
         function()
         {
            settings.rotate = true;
         }
         );
         DoScroll($obj, settings);
      }
      else 
      if (settings.mode == 'paginate')
      {
         $obj.css('overflow-y', 'auto'); 

         $('.headline').css('position', 'relative');
         $('.headline').css('height', 'auto');
         $('.headline').css('top', '0');

         var currentPage = 0;
         var repaginate = function() 
         {
           $obj.find('.headline').hide()
            .slice(currentPage * settings.numPerPage,
              (currentPage + 1) * settings.numPerPage)
            .show();
         };

         var numRows = $obj.find('.headline').length;
         var numPages = Math.ceil(numRows / settings.numPerPage);
         var $pager = $('<div class="pager"></div>');
         for (var page = 0; page < numPages; page++) 
         {
           $('<span class="page-number"></span>').text(page + 1)
             .bind('click', {newPage: page}, function(event) 
          {
             currentPage = event.data['newPage'];
             repaginate();
             $(this).addClass('active')
               .siblings().removeClass('active');
           }).appendTo($pager).addClass('clickable');
       }
       $pager.prependTo($obj).find('span.page-number:first').addClass('active');

       repaginate();
     }
   }

   function DoScroll($obj, settings) 
   {
      settings.line_count += settings.rotate ? -2 : 0;
      $('p', $obj).css('top', settings.line_count);

      if (settings.line_count<-1 * settings.news_height)
      {
         settings.line_count = settings.ticker_height;
      }
      setTimeout( function() { DoScroll($obj, settings) }, 50);
   }

})(jQuery);