let selectedParameter = "products"

        function showParameter(id){
            if(selectedParameter != id){
                document.getElementById(selectedParameter).classList.add('hidden');
                document.getElementById(id).classList.remove('hidden');
                selectedParameter = id
            }
        }