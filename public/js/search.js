let filters = {
    q: '',
    order: '',
    category: '',
    sub_category: '',
    item_type: '',
    start_date: '',
    end_date: '',
    sale_status: '',
    listing_type: '',
    neighbourhood: '',
    item_condition: '',
    age: '',
    photos: false
};

const page = document.getElementById('searchResults');
const cityDropdown = document.getElementById('location');
const neighborhoodDropdown = document.getElementById('searchSelectNeighborhood');
switchLayout('grid');
const initialCityEvent = new Event('change');
initialCityEvent.target = cityDropdown.value;

cityDropdown.addEventListener('change', (event) => {
    const neighborhoods = city;
    const selectedCity = event.target.value;

    if (!selectedCity) {
        return;
    }

    emptySelectField(neighborhoodDropdown);

    for (let i = 0; i < neighborhoods[selectedCity].length; i++) {
        let option = document.createElement('option');
        option.text = neighborhoods[selectedCity][i];
        option.value = neighborhoods[selectedCity][i];
        neighborhoodDropdown.add(option);
    }

});

cityDropdown.dispatchEvent(initialCityEvent);
page.style.display = '';

function switchLayout(layout) {
    const gridLayout = document.getElementById('gridLayout');
    const gridButton = document.getElementById('gridSelect');
    const listLayout = document.getElementById('listLayout');
    const listButton = document.getElementById('listSelect');

    if (layout === 'grid') {
        gridLayout.style.display = '';
        gridButton.classList.add('layout-selected');
        listLayout.style.display = 'none';
        listButton.classList.remove('layout-selected');
        return;
    }

    listLayout.style.display = '';
    listButton.classList.add('layout-selected');
    gridLayout.style.display = 'none';
    gridButton.classList.remove('layout-selected');

}

function selectedOrderFilter(event) {
    const filter = event.target.value;
    const keyword = page.getElementsByTagName('input').keyword.value;
    const requestUrl = `/search?q=${keyword}&order=${filter}`;
    window.location.href = requestUrl;
}

function selectedCategoryFilter(event) {
    const subCategorySelect = document.getElementById('searchSubCategorySelect');
    const itemTypeSelect = document.getElementById('searchItemTypeSelect');
    emptySelectField(subCategorySelect);
    emptySelectField(itemTypeSelect);

    if (typeof event.target.value === 'undefined') {
        return;
    }

    const categoryName = event.target.value;
    const category = categories.filter(category => category.name === categoryName)[0];
    const filtered = subCategories.filter(subCategory => subCategory.category_id === category.id);
    const select = document.getElementById('searchSubCategorySelect');

    filtered.forEach(
        subCategory => {
            let option = document.createElement('option');
            option.text = subCategory.name;
            option.value = subCategory.name;
            select.add(option);
        }
    );
}

function selectedSubCategoryFilter(event) {
    const itemTypeSelect = document.getElementById('searchItemTypeSelect');
    emptySelectField(itemTypeSelect);

    if (typeof event.target.value === 'undefined') {
        return;
    }

    const subCategoryName = event.target.value;
    const subCategory = subCategories.filter(subCategory => subCategory.name === subCategoryName)[0];
    const filtered = itemTypes.filter(itemType => subCategory.id === itemType.sub_category_id);
    const select = document.getElementById('searchItemTypeSelect');

    filtered.forEach(
        itemType => {
            let option = document.createElement('option');
            option.text = itemType.name;
            option.value = itemType.name;
            select.add(option);
        }
    );
}

function emptySelectField(field) {

    length = field.options.length - 1;

    for (let i = length; i >= 0; i--) {

        if (i > 0) {
            field.remove(i);
        }

    }

}

function setListingType(input) {

    if (isSet(input.listed_by_business.checked) && !isSet(input.listed_by_individual.checked)) {
        return 'business';
    }

    if (isSet(input.listed_by_individual.checked) && !isSet(input.listed_by_business.checked)) {
        return 'individual';
    }

    return 'all';

}

function submitSearch() {

    const filters = setFilters();
    let requestUrl = `/search`

    for (let filter in filters) {

        if (filters.hasOwnProperty(filter) && isSet(filters[filter])) {

            if (requestUrl.indexOf('search?') === -1) {
                requestUrl += '?';
            } else {
                requestUrl += '&';
            }

            requestUrl += `${filter}=${filters[filter]}`;
        }
    }

    window.location.href = requestUrl;
}

function setFilters() {
    const input = page.getElementsByTagName('input');
    const select = page.getElementsByTagName('select');

    filters = {
        q: input.keyword.value,
        order: select.order_filter.value,
        category: select.category.value !== 'Select Category' ? select.category.value : '',
        sub_category: select.sub_category.value !== 'Select Sub Category' ? select.sub_category.value : '',
        item_type: select.item_type.value !== 'Select Item Type' ? select.item_type.value : '',
        start_date: input.start_date.value,
        end_date: input.end_date.value,
        sale_status: input.for_sale.checked ? 'sale' : '',
        listing_type: this.setListingType(input),
        neighbourhood: select.neigborhood.value !== 'Select Neighborhood' ? select.neigborhood.value : '',
        item_condition: select.condition.value !== 'Select Condition' ? select.condition.value : '',
        age: select.age.value !== 'Select Age' ? select.age.value : '',
        // photos: input.show_ads_photo.checked
    };

    return filters;
}

function isSet(value) {

    if (typeof value === 'undefined') {
        return false;
    }

    if (typeof value === 'boolean') {
        return value;
    }

    if (typeof value === 'string') {

        if (value.trim().length <= 0) {
            return false;
        }

    }

    if (typeof value === 'number') {

        if (isNaN(value)) {
            return false;
        }

    }

    return true;

}

$(() => {
    // const picker = $('input[name="daterange"]');

    // picker.daterangepicker({ opens: 'left' }, (start, end, label) => {
    //     document.getElementById('startDate').value = start.format('YYYY-MM-DD');
    //     document.getElementById('endDate').value = end.format('YYYY-MM-DD');
    // });

    // set default datepicker value to blank
    // picker.val('');
});
