<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServicosModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_servicos(){
        //Inicio da montagem do select
        $this->db->select('res.id as id_area, 
        res.nome as nome, 
        foto.img_url as img_url');

        //Seta from
        $this->db->from('areas as res');
        //Seta o Join com a tabela de fotos
        $this->db->join('areas_foto as foto', 'res.id = foto.area_id');
        //Executa a query
        $query = $this->db->get();
        //Verifica se retornou alguma informacao
        if ($query->num_rows() > 0)
        {
            $data = $query->result();
            //Retorna o resultado da query
            return $data;
        }
        else
            return array();
    }
    
    function get_area($id){
        $this->db->where('area_id',$id);
        $query = $this->db->get('servicos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_pedido($id){
        $this->db->where('area_id',$id);
        $this->db->where('status', "Aberto");
        $query = $this->db->get('pedidos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_historico($usuario_id){
        $this->db->where('id_usuario',$usuario_id);
        $query = $this->db->get('pedidos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function validate_login($email, $password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);		
		$query = $this->db->get('usuarios');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }
    function validate_login_advocacia($email, $password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);		
		$query = $this->db->get('login');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }

    function validate_login_fornecedor($email, $password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);		
		$query = $this->db->get('fornecedor');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }

    function validate_aceita_pedido($id_pedido, $id){
        $this->db->set('status', 'Em fase de atendimento');
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');

        $this->db->set('id_atendente', $id);
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');

        $this->db->set('status_db', 'atendimento');
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');
        return true;
    }

    function validate_atendimento($id){
        $this->db->where('id_atendente', $id);
        $this->db->where('status_db', 'atendimento');
        $query = $this->db->get('pedidos');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }
    function validate_atendimento_atual($id){
        $this->db->where('id', $id);
        $this->db->where('status_db', 'atendimento');
        $query = $this->db->get('pedidos');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }
    function atendimento_atual($id){
        $this->db->where('id',$id);
        $this->db->where('status_db', "atendimento");
        $query = $this->db->get('pedidos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }


    function validate_cadastrar_valor($id_pedido, $valor){
        $this->db->set('valor', $valor);
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');

        $this->db->set('status', 'Em fase de pagamento');
        $this->db->where('id', $id_pedido);
        $this->db->update('pedidos');
        return true;
    }

    function validade_pedido_pago($id){
        $this->db->set('status','Pagamento aprovado');
        $this->db->where('id',$id);
        $this->db->update('pedidos');

        return true;
    }

    function validade_finaliza_pedido($id){
        $this->db->set('status','Concluído');
        $this->db->set('status_db','Finalizado');
        $this->db->where('id',$id);
        $this->db->update('pedidos');

        return true;
    }

    function get_teste(){

        $query = $this->db->get('teste_carrinho');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_opcoes(){
        
        $query = $this->db->get('opcoes');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_id(){
        
        $query = $this->db->get('pedidos_caixa');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_cardapio($id){
        $this->db->where('cardapio_id',$id);
        $query = $this->db->get('cardapio');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_pergunta($id){
        $this->db->where('cardapio_id',$id);
        $query = $this->db->get('pergunta');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_resposta($id){
        $this->db->select();
        $this->db->where('pergunta_id',$id);
        $query = $this->db->get('resposta');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_pedidos_caixa(){
        
        $this->db->where('status','Aberto');
        $query = $this->db->get('pedidos_caixa');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }

    function get_numero_pedidos(){
        
        $query = $this->db->get('pedidos_caixa');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    
    function get_novidades(){
        $query = $this->db->query("SELECT * FROM produtos WHERE status ='disponivel' ORDER BY id DESC LIMIT 5 ");
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_produtos($type){
        $this->db->where('tipo', $type);
        $this->db->where('status', 'disponivel');
        $query = $this->db->get('produtos');
        if($query->num_rows()> 0){
            $data = $query->result();
            return $data;
        }else
            return array();
    }
    function validate_login_garimpos($email, $password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);		
		$query = $this->db->get('login_garimpos');
			if($query->num_rows() > 0){
				$data = $query->result();
                return $data;	
			}else{
				return false;
			}
    }

    function get_reservas($id){
        $this->db->where('id_reserva',$id);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function validate_reservar($id_comprador,$id_produto){
        $this->db->set('status', 'reservado');
        $this->db->set('id_reserva', $id_comprador);
        $this->db->where('id', $id_produto);
        $this->db->update('produtos');

        return true;
    }


    function get_numero_produtos(){
        
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    
    function get_curtidas($id_cliente, $id_produto){
        $this->db->where('id_cliente',$id_cliente);
        $this->db->where('id_produto',$id_produto);
        $query = $this->db->get('curtidas_garimpos');
        if($query->num_rows()>0){
            $data = $query;
            return $data;
        }else{
            return array();
        }
    }
    function descurtir($id_cliente,$id_produto){
        $query = $this->db->query("DELETE FROM curtidas_garimpos WHERE id_produto ='$id_produto' AND id_cliente='$id_cliente'");
        if($query){         
            return $query;
        }else
             return array();
    }
    function get_perfil($id){
        $this->db->where('id',$id);
        $query = $this->db->get('login_garimpos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_numero_pecas($id){
        $this->db->where('id_vendedor', $id);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    function get_numero_curtidas($id){
        $this->db->where('id_vendedor', $id);
        $query = $this->db->get('curtidas_garimpos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
        }else
             return array();
    }
    
    function get_produtos_relacionados($id_vendedor, $id_produto){
        
        $this->db->where('id_vendedor',$id_vendedor);
        $this->db->where('id !=', $id_produto);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
            
        }else
             return array();

    }
    function get_produtos_vendedor($id_vendedor){
        
        $this->db->where('id_vendedor',$id_vendedor);
        
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
            
        }else
             return array();

    }

    function get_curtidas_cliente($id){
        $this->db->where('id_cliente', $id);
        $query = $this->db->get('curtidas_garimpos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
            
        }else
             return array();
    }
    function get_produtos_curtidos($id){
        $this->db->where('id', $id);
        $query = $this->db->get('produtos');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
            
        }else
             return array();
    }

    function get_pedidos_caixa_lista($id){
        $this->db->where('id_pedido', $id);
        $query = $this->db->get('pedidos_galera');
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;
            
        }else
             return array();
    }

    function finaliza_pedido_galera($id){
        $this->db->set('status', 'Pago');
        $this->db->where('id', $id);
        $this->db->update('pedidos_caixa');

        return true;
    }
    
}
?>
