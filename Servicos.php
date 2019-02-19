<?php

header('Content-Type: application/json');


defined('BASEPATH') OR exit('No direct script access allowed');

    class Servicos extends CI_Controller {
        function __construct()
        {
            parent::__construct();

            // carrega o model RestauranteModel e da um Alias de restaurante
            $this->load->model('ServicosModel', 'servicos', TRUE);
            $this->load->helper('url');
        }
        
    public function get_restaurantes(){
        $restaurantes = $this->servicos->get_restaurantes();
		$response = array();
		foreach($restaurantes as $res){
			$restaurante = array();
			$restaurante["id"] = $res->id;
            $restaurante["nome"] = $res->nome;
            $restaurante["tipo"] = $res->tipo;
            $restaurante["imgurl"] = $res->img_url;
			array_push($response,$restaurante);
		}
		echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function get_cardapio($id){
        $cardapios = $this->servicos->get_cardapio($id);
        $response = array();
        foreach($cardapios as $res){
            $cardapio = array();
            $cardapio["id"] = $res->id;
            $cardapio["nome"] = $res->nome;
            $cardapio["ingredientes"] = $res->ingredientes;
            $cardapio["preco"] = $res->preco;
            $cardapio["id_restaurante"] = $res->restaurante_id;
            array_push($response,$cardapio);
        }
        echo json_encode($response);
    }

    public function enviar_mail(){
        ini_set('display_errors', 1);

        $from = 'administracao@vservices.com';
        $to= 'viniblima2016@gmail.com';
        $subject= 'Teste de Assunto';
        $message = 'O correio do php funciona';
        //$headers "De:".$from;
        $email = mail($to,$subject,$message);
        if($envio){
            echo "Mensagem enviada com sucesso";
        }
        else{
            echo "A mensagem não pode ser enviada";
        }
    }
    
    
}
?>
