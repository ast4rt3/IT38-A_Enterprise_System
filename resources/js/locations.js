import philippines from 'philippines';

const { regions, provinces, cities } = philippines;

document.addEventListener('DOMContentLoaded', () => {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');

    // Function to populate the region select dropdown with both key and long name
    function populateRegionDropdown() {
        console.log('Available regions: ', regions); // Debugging log

        regions.forEach(region => {
            const option = document.createElement('option');
            option.value = region.key;  // Set the key as the value
            option.textContent = `${region.key} - ${region.long}`;  // Show both key and long name
            regionSelect.appendChild(option);
        });
    }

    // Populate region dropdown initially
    populateRegionDropdown();

    // Add change event listener for region selection
    regionSelect.addEventListener('change', () => {
        const selectedRegion = regionSelect.value;
        console.log(`Selected Region: ${selectedRegion}`); // Debugging log

        if (selectedRegion) {
            provinceSelect.innerHTML = '<option value="">Select Province</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';

            const filteredProvinces = provinces.filter(
                province => province.region === selectedRegion
            );

            console.log('Filtered Provinces: ', filteredProvinces); // Debugging log
            if (filteredProvinces.length === 0) {
                console.log('No provinces found for the selected region');
            } else {
                filteredProvinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.key;  // Use key as value, assuming "key" is the identifier
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            }
        }
    });

    // Add change event listener for province selection
    provinceSelect.addEventListener('change', () => {
        const selectedProvince = provinceSelect.value;
        console.log(`Selected Province: ${selectedProvince}`); // Debugging log

        if (selectedProvince) {
            citySelect.innerHTML = '<option value="">Select City</option>';

            const filteredCities = cities.filter(
                city => city.province === selectedProvince
            );

            console.log('Filtered Cities: ', filteredCities); // Debugging log
            if (filteredCities.length === 0) {
                console.log('No cities found for the selected province');
            } else {
                filteredCities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            }
        }
    });
});
