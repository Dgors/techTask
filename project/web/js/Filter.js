
const filters = Array.from(document.getElementsByClassName('filter'));
const objects = document.getElementsByClassName('marker');

filters.forEach((filter) => {
    filter.addEventListener('click', function() {
        const count = objects.length;
        for (let i = 0; i < count; i++) {
            let classList = objects[i].classList;
            let value = objects[i].value;
            if (classList.contains(this.name) && !classList.contains('hidden') && value === '' && !this.checked) {
                classList.add('hidden');
                objects[i].value = this.name;
            } else if (classList.contains(this.name) && classList.contains('hidden') && value === this.name && this.checked) {
                classList.remove('hidden');
                objects[i].value = '';
            }
        }

    })
});

