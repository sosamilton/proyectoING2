<?php

namespace CB\InicioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class InicioBundle extends Bundle
{
	public function getParent()
    {
		return 'FOSUserBundle';
    }
}
