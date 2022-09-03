<?php

namespace Janrsilva\OlxAdImport;

    /**
     * @see https://github.com/olxbr/ad_integration
     */
class Ad extends BaseDto
{
    const OPERATION_INSERT = 'insert';
    const OPERATION_UPDATE = 'update';
    const TYPE_SALE = 's';
    const TYPE_RENT  = 'u';

    /**
     * O identificador do anúncio.
     * Deve ser único no JSON (caso haja mais de um anúncio no JSON).
     *
     * @optional true
     * @var      string $id Regular expression: [A-Za-z0-9_{}-]{1,19}
     */
    public $id;

    /**
     * Valores para identificar qual será a operação a ser feita:
     * insert para inserir ou editar anúncios
     * delete para despublicar anúncios.
     *
     * @optional false
     * @var      string $operation enum: [insert, delete]
     */
    public $operation;

    /**
     * Categoria do anúncio.
     *
     * @optional false
     * @var      int $category
     */
    public $category;

    /**
     * Título do anúncio. Mínimo de 2 e máximo de 90 caracteres.
     *
     * @optional false
     * @var      string $subject
     */
    public $subject;

    /**
     * Descrição do anúncio. Mínimo de 2 e máximo de 6 mil caracteres
     *
     * @optional false
     * @var      string $body
     */
    public $body;

    /**
     * Telefone para contato.
     * Mínimo de 10 e máximo de 11 caracteres.
     * Enviar DDD + Telefone sem caracteres especiais ou espaços.
     *
     * @optional false
     * @var      int $phone
     */
    public $phone;

    /**
     * Tipo de oferta do anúncio. s para venda e u para aluguel.
     *
     * @optional false
     * @var      string $type enum: [s, u]
     */
    public $type;

    /**
     * Preço do anúncio (não aceita centavos)
     *
     * @optional true
     * @var      int $price
     */
    public $price;

    /**
     * O CEP do anúncio. Sem caracteres especiais ou espaços. Apenas números.
     *
     * @optional false
     * @var      int $zipcode
     */
    public $zipcode;


    /**
     * Lista de parâmetros com as características do anúncio.
     * Os valores dessa lista variam de acordo com a categoria do anúncio.
     *
     * @optional true
     * @var      array $params
     */
    public $params;

    /**
     * URL de imagens que serão inseridas no anúncio do olx.com.br.
     * Não pode haver URLs repetidas neste array.
     * Máximo de 20 imagens.
     * Importante: a primeira imagem da lista será a imagem principal do anúncio!
     *
     * @optional true
     * @var      string[] $images URL da imagem
     */
    public $images;

    /**
     * URL de vídeo3. que será inserida no anúncio do olx.com.br deve ser
     * apenas do https://www.youtube.com/.
     * Aceito 1 vídeo por anúncio!
     *
     * Ex:
     *  [...]
     *    },
     *    "videos": [
     *        "https://www.youtube.com/watch?v=Vt&28raiI1q5"
     *    ]
     *  },
     *  [...]
     *
     * @optional true
     * @var      string[] $videos URL do vídeo
     */
    public $videos;
}