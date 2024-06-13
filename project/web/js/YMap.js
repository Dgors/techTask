async function main() {
    // Waiting for all api elements to be loaded
    await ymaps3.ready;
    const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker} = ymaps3;

    const mapElement = document.getElementById('app')
    // Initialize the map
    const map = new YMap(
        // Pass the link to the HTMLElement of the container
        mapElement,
        // Pass the map initialization parameters
        {
            location: {
                center: [82.915, 55.044],
                zoom: 5,
            },
        },
    );

    map.addChild(new YMapDefaultSchemeLayer());
    map.addChild(new YMapDefaultFeaturesLayer());

    window.perem = {map, YMapDefaultFeaturesLayer, YMapMarker};

}
main().then(newMarkerAdd => {
    const {YMapComplexEntity} = ymaps3;
    class newMarker {
        #obj_coordinates;
        #obj_name;
        #obj_pos;
        #obj_reg;
        #id_reg;
        #id_pos;

        constructor(coordinates, nameMarker, markerPosition, markerRegion, id_region, id_position) {
            this.#obj_name = nameMarker;
            this.#obj_coordinates = coordinates;
            this.#obj_pos = markerPosition;
            this.#obj_reg = markerRegion;
            this.#id_reg = id_region;
            this.#id_pos = id_position;
            this._newMarker();
        }


        _newMarker() {
            const markerElement = document.createElement('div');
            const popupElement = this._createPopup(markerElement);

            markerElement.className = `marker pos${this.#id_pos} reg${this.#id_reg}`;
            markerElement.value = '';
            popupElement.classList.add('hidden');



            const marker = new YMapMarker(
                {
                    coordinates: this.#obj_coordinates,
                },
                markerElement
            );

            map.addChild(marker);

            markerElement.onclick = () => {

                markerElement.classList.add('red');
                popupElement.classList.remove('hidden');
            };

            markerElement.appendChild(popupElement);

        }

        _createPopup(markerElement) {
            const popupMarkerElement = document.createElement('div');
            const closePopupElement = document.createElement('div');

            closePopupElement.className = 'closeModal popupClose';
            popupMarkerElement.className = 'popup popupMarkerElement';
            popupMarkerElement.appendChild(closePopupElement);
            popupMarkerElement.appendChild(this._popupContent());

            closePopupElement.addEventListener('click', (event) => {
                event.stopPropagation();
                popupMarkerElement.classList.add('hidden');
                markerElement.classList.remove('red');
            })




            return popupMarkerElement;
        }

        _popupContent() {
            const popupContent = document.createElement('div');
            const objectName = document.createElement('div');
            const objectPosition = document.createElement('div');
            const objectRegion = document.createElement('div');

            popupContent.className = 'popup_content';
            objectName.className = 'name obj_name';
            objectPosition.className = 'obj_pos';
            objectRegion.className = 'obj_reg';

            objectName.innerHTML = `<h3 class="obj_text obj_h1 obj_name">${this.#obj_name}</h3>`;
            objectPosition.innerHTML = `<p class="obj_text obj_p obj_pos">Должность: ${this.#obj_pos}</p>`;
            objectRegion.innerHTML = `<p class = "obj_text obj_p obj_reg">Регион: ${this.#obj_reg}</p>`

            popupContent.appendChild(objectName);
            popupContent.appendChild(objectPosition);
            popupContent.appendChild(objectRegion);

            return popupContent;
        }
    }




    window.new_Marker = newMarker;
    const {map, YMapMarker} = perem;

});
window.onload = () => {

// let elem = new new_Marker([82.915, 55.044], 'name', 'инженер', 'север');

}