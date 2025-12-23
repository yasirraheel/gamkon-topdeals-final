'use strict';

(function () {
    // Initialize all Tagify inputs
    function initializeTagify() {
        // Key Skills Tagify - using class selector
        const skillsInputs = document.querySelectorAll('.tagify-skills');
        const skillsWhitelist = [
            'A# .NET', 'ABAP', 'ActionScript', 'Ada', 'Agda', 'Algol', 
            'AMPL', 'APL', 'Assembly language', 'ASP.NET'
        ];

        skillsInputs.forEach(input => {
            if (!input.tagify) { // Check if not already initialized
                new Tagify(input, {
                    whitelist: skillsWhitelist,
                    maxTags: 10,
                    dropdown: {
                        maxItems: 20,
                        classname: 'tags-inline',
                        enabled: 0,
                        closeOnSelect: false,
                    },
                });
            }
        });

        // Language Spoken Tagify - using class selector
        const languagesInputs = document.querySelectorAll('.tagify-language');
        const languagesWhitelist = ['English', 'Bangla', 'Hindi', 'Spanish', 'Urdu'];

        languagesInputs.forEach(input => {
            if (!input.tagify) { // Check if not already initialized
                new Tagify(input, {
                    whitelist: languagesWhitelist,
                    maxTags: 10,
                    dropdown: {
                        maxItems: 20,
                        classname: 'tags-inline',
                        enabled: 0,
                        closeOnSelect: false,
                    },
                });
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', initializeTagify);

    // Optional: Expose the function for dynamic initialization
    window.initializeTagify = initializeTagify;
})();