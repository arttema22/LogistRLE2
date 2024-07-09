<?php

use App\Models\Sys\SetupIntegration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setup_integrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('url')->unique();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->text('access_token')->nullable();
            $table->json('additionally')->nullable();
            $table->string('help_api')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
        });

        SetupIntegration::create([
            'name' => 'E1-card',
            'url' => 'https://publicapi.e1-card.ru',
            'user_name' => 'RLogist',
            'password' => 'Qwer-302',
            'access_token' => 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IlJMb2dpc3QiLCJodHRwOi8vc2NoZW1hcy56Z3MubG9jL2UxMDAvaWRlbnRpdHkvY2xhaW1zL2xvZ2luIjoiUkxvZ2lzdCIsImh0dHA6Ly9zY2hlbWFzLnpncy5sb2MvZTEwMC9pZGVudGl0eS9jbGFpbXMvdXNlcnR5cGUiOiJDbGllbnRQdWJsaWMiLCJodHRwOi8vc2NoZW1hcy56Z3MubG9jL2UxMDAvaWRlbnRpdHkvY2xhaW1zL2NsaWVudFRyYWRlciI6IjQwIiwiaHR0cDovL3NjaGVtYXMuemdzLmxvYy9lMTAwL2lkZW50aXR5L2NsYWltcy9jbGllbnRUZXJyaXRvcnkiOiIyIiwiaHR0cDovL3NjaGVtYXMuemdzLmxvYy9lMTAwL2lkZW50aXR5L2NsYWltcy9jbGllbnRpZCI6InB1YmxpYy1hcGktY2xpZW50LWV4dGVybmFsIiwiaHR0cDovL3NjaGVtYXMuemdzLmxvYy9lMTAwL2lkZW50aXR5L2NsYWltcy9zZXNzaW9ucmVuZXdhbGtleSI6IjUwNzgwNDNhZjdhODQ4YjBhM2U4NzVjMWU2YzcxMTRhIiwibmJmIjoxNzA5MTcwMzQ5LCJleHAiOjE3MTE3NjI2NDksImlhdCI6MTcwOTE3MDM0OSwiaXNzIjoiRTEwMCJ9.3CG4JJMLp90LiagB-nDu53nHB0Skru-s-Au4qoP3f6J4nkJnNHCV2qMRvZOGx--kekfFXdwjU_ARYF6t2v2Oy6AYJeskbacsgAWNcoDFQKGhSXaLVlUgvkNSluThqlivMQy5eLOfVb0xx4cQgy3jd9c-9VbHhh0lQS3M3o9i7wOBlukGCH3NmHXSVUhjJv4E_N3fZ7TLFFa_M2ZZ2EuT6bTft6kOVac6Sw_6GCs2yDt0bkgJ09-fuhiD6I67eu3gIXAaMVg7sx-zpVrZMPk0QHIn832TI0sKJc8gm3MXM77RS7tUaZojjo7gFqdTLmhRkwaiU2JJYZkoosiBHfB5mA',
            'additionally' => [
                'clientCode' => '001715406',
            ],
            'help_api' => 'https://publicapi.e1-card.ru/',
        ]);

        SetupIntegration::create([
            'name' => 'Монополия',
            'url' => 'https://monopoly.online/fuel.api',
            'user_name' => 'naa@rlexport.ru',
            'password' => 'P1$t0let',
            'access_token' => 'eyJhbGciOiJBMjU2S1ciLCJlbmMiOiJBMjU2Q0JDLUhTNTEyIiwidHlwIjoiSldUIiwiY3R5IjoiSldUIn0.Xn4SFQZIgdKvZdww_uNv9fWSir1uisWcD_NqzrhG1wxVfyWkboBukuyb0X-sSQgGRM8KPiMBKFVkrHb8-bPlPMZ9DRhULfMY.26K9vEf1EXE3jtr6MsKssg.EDwhuKhYjF_Cs4__HEENqow2r3uUPSdB4lBiTyj7mti0O7E1cCFUZpz40aTmW-ACL2_VC9ua3fG_jA89yYOtbLESG21WmnbpkLcuazeAiog5jVqVPji12aWcYj9ppr4PjJCopmLpNrOLj_ViRVasFAXrtPs5MJ-HQzdrNVBPeVtQC9ZtVS0TK_-6dAoBujDAkOQrAsThwalPRxmZsyQCzjue443RXO5eL2qTCkDqYjsACnCkEww_rI6EasBk7HfE92wPVsuPmOUASOSl1EQpBeRQpFV7WkKLv_lz_xXf-LBTM4UCqHA-REeSpVJLdOmTIKc_7yEcYDwtZd-oXFBVPgY7psQ5msCWA1fvL1FOXG4rWDmXZh43_itK6BgodSNrm-MivcMwaKJaf6LgLlDd8kmLshPvjaSx3UHdMgPdX1rpUaOiWuvQuQmPQVvv2ou81KM2UIyhQzxQEaIZ4CMoFKmGm2-jLNgk8Vs5Mh94d_gBUPU4fj7cP_k2MzBO-cQrr06uzmKpH-Gui-De6ONwf182BDc-eXvqV9Tbc7KB2N0g4NRJumR0yPdFXCAnbNp_rxlDIAas7h2dcEu00SxM0RsY_7F8Yc3NAaadV7pSfG3cqr5EsxONbCZcYm5-P2aP.ZItnUAYZmGjn7mEZeMsp9934R1tq4U3RMrrNsoz22wY',
            'additionally' => [
                'contract_id' => '7efdb271-bc26-11ed-86cc-00505601d4a1',
            ],
            'help_api' => 'https://help.monopoly.online/pages/viewpage.action?pageId=3475181',
        ]);

        SetupIntegration::create([
            'name' => '1c Fresh',
            'url' => 'https://monopoly.online/fuel.api',
            'user_name' => 'naa@rlexport.ru',
            'password' => 'P1$t0let',
            'access_token' => 'eyJhbGciOiJBMjU2S1ciLCJlbmMiOiJBMjU2Q0JDLUhTNTEyIiwidHlwIjoiSldUIiwiY3R5IjoiSldUIn0.Xn4SFQZIgdKvZdww_uNv9fWSir1uisWcD_NqzrhG1wxVfyWkboBukuyb0X-sSQgGRM8KPiMBKFVkrHb8-bPlPMZ9DRhULfMY.26K9vEf1EXE3jtr6MsKssg.EDwhuKhYjF_Cs4__HEENqow2r3uUPSdB4lBiTyj7mti0O7E1cCFUZpz40aTmW-ACL2_VC9ua3fG_jA89yYOtbLESG21WmnbpkLcuazeAiog5jVqVPji12aWcYj9ppr4PjJCopmLpNrOLj_ViRVasFAXrtPs5MJ-HQzdrNVBPeVtQC9ZtVS0TK_-6dAoBujDAkOQrAsThwalPRxmZsyQCzjue443RXO5eL2qTCkDqYjsACnCkEww_rI6EasBk7HfE92wPVsuPmOUASOSl1EQpBeRQpFV7WkKLv_lz_xXf-LBTM4UCqHA-REeSpVJLdOmTIKc_7yEcYDwtZd-oXFBVPgY7psQ5msCWA1fvL1FOXG4rWDmXZh43_itK6BgodSNrm-MivcMwaKJaf6LgLlDd8kmLshPvjaSx3UHdMgPdX1rpUaOiWuvQuQmPQVvv2ou81KM2UIyhQzxQEaIZ4CMoFKmGm2-jLNgk8Vs5Mh94d_gBUPU4fj7cP_k2MzBO-cQrr06uzmKpH-Gui-De6ONwf182BDc-eXvqV9Tbc7KB2N0g4NRJumR0yPdFXCAnbNp_rxlDIAas7h2dcEu00SxM0RsY_7F8Yc3NAaadV7pSfG3cqr5EsxONbCZcYm5-P2aP.ZItnUAYZmGjn7mEZeMsp9934R1tq4U3RMrrNsoz22wY',
            'additionally' => [
                'contract_id' => '7efdb271-bc26-11ed-86cc-00505601d4a1',
            ],
            'help_api' => 'https://help.monopoly.online/pages/viewpage.action?pageId=3475181',
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup_integrations');
    }
};
