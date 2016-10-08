
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>

        (function($) {

            'use strict';

            $.fn.df3TableSort = function(options) {

                var _parent = this;

                var settings = $.extend( {
                    columnSortedIndex: false,
                    columnOrder: null,
                }, options);

                _parent.greet = function() {
                    console.log(settings);
                };

                function collectColumnData(rows, columnIndex) {
                    var collection = [];
                    for (var i = 0; i < rows.length; i++) {
                        var _td = rows.eq(i).find('td'),
                        _value = _td[0].dataset.sortValue || _td.eq(columnIndex).text();
                        collection.push({
                            value: rows.eq(i).find('td').eq(columnIndex).text(),
                            html: rows[i].outerHTML
                        });
                    }
                    return collection;
                }

                function sortOnLoad() {
                    if (!settings.columnSorted) {
                        return false;
                    }


                }

                return _parent.each(function(index, table) {

                    // get number of rows
                    var rows = $(table).find('tbody tr'),
                        columnIndex = 1,
                        direction = 'asc';
                    
                    // add click event listener to header cell
                    $(table).find('thead th').on('click', function(event) {

                        var sortType = this.dataset.sortType || 'string',
                            columnData = [],
                            rowsHTML = '',
                            sortOrder = ($(this).hasClass('asc')) ? 'desc' : 'asc',
                            thText = $(this).text();

                        if (settings.columnOrder !== null) {
                            sortOrder = settings.columnOrder;
                        }

                        // Decorate th cell
                        $(table).find('thead th').removeClass('asc desc');
                        $(this).addClass(sortOrder);

                        // Get to know the column index
                        columnIndex = (!settings.columnSortedIndex) ? event.target.cellIndex : settings.columnSortedIndex;

                        console.log(columnIndex);

                        // get data from column index
                        columnData = collectColumnData(rows, columnIndex);

                        columnData.sort(function(a, b) {
                            if (sortType == 'integer') {
                                return (sortOrder == 'asc') ? a.value - b.value : b.value - a.value;
                            }

                            if (sortType == 'string') {
                                return (sortOrder == 'asc') ? a.value > b.value : b.value > a.value;
                            }

                            console.log(a.value);
                        });

                        // render table body with new sorted data
                        for (var i = 0; i < columnData.length; i++) {
                            rowsHTML += columnData[i].html;
                        }

                        $(table).find('tbody').html(rowsHTML);
                    });

                    setTimeout(function() {
                        if (settings.columnSortedIndex !== false) {
                            console.log('test');
                            $(table).find('thead th').eq(settings.columnSortedIndex).trigger('click');

                            // reset settings defaults 
                            settings.columnSortedIndex = false;
                            settings.columnOrder = null;
                        }
                    }, 200);                    

                });
            };

            $.fn.df3TableSort.greet2 = function(name) {
                console.log('hello ' + name);
            };

        })(jQuery);

        (function($) {
            $(document).ready(function() {
                $('.table').df3TableSort({
                    columnSortedIndex: 0,
                    columnOrder: 'asc'
                });
            });
        })(jQuery);

        </script>
    </body>
</html>
