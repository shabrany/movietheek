(function ($) {

	'use strict';

	$.fn.df3TableSort = function (options) {

		var _parent = this;

		var settings = $.extend({
			columnSortedIndex: false,
			columnOrder: null,
		}, options);

		_parent.greet = function () {
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

		function naturalSorter(as, bs) {
			var a, b, a1, b1, i = 0, n, L,
				rx = /(\.\d+)|(\d+(\.\d+)?)|([^\d.]+)|(\.\D+)|(\.$)/g;
			if (as === bs) return 0;
			a = as.toLowerCase().match(rx);
			b = bs.toLowerCase().match(rx);
			L = a.length;
			while (i < L) {
				if (!b[i]) return 1;
				a1 = a[i],
					b1 = b[i++];
				if (a1 !== b1) {
					n = a1 - b1;
					if (!isNaN(n)) return n;
					return a1 > b1 ? 1 : -1;
				}
			}
			return b[i] ? -1 : 0;
		}

		return _parent.each(function (index, table) {

			// get number of rows
			var rows = $(table).find('tbody tr'),
				columnIndex = 1,
				direction = 'asc';

			// add click event listener to header cell
			$(table).find('thead th').on('click', function (event) {

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

				// get data from column index
				columnData = collectColumnData(rows, columnIndex);

				// columnData.sort(function (a, b) {
				// 	return sortAlphaNum(a.value, b.value);
				// });

				columnData.sort(function (a, b) {
					return naturalSorter(a.value, b.value);
				});

				if (sortOrder == 'desc') {
					columnData.reverse();
				}

				// render table body with new sorted data
				for (var i = 0; i < columnData.length; i++) {
					rowsHTML += columnData[i].html;
				}

				$(table).find('tbody').html(rowsHTML);
			});

			// Execute method after
			setTimeout(function () {
				if (settings.columnSortedIndex !== false) {

					$(table).find('thead th').eq(settings.columnSortedIndex).trigger('click');

					// reset settings defaults 
					settings.columnSortedIndex = false;
					settings.columnOrder = null;
				}
			}, 0);
		});
	};

})(jQuery);