<?php
    namespace App\Helpers; 

    class ResponseJSON {

        public static function unauthorized(){
            return response()->json([
                'message' => 'Unathorized user'
            ], 401);
        }
    }
?>