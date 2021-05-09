const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"]},"password.email":{"uri":"password\/email","methods":["POST"]},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"password\/reset","methods":["POST"]},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"]},"home":{"uri":"home","methods":["GET","HEAD"]},"AdminEmployees.index":{"uri":"AdminEmployees","methods":["GET","HEAD"]},"AdminEmployees.create":{"uri":"AdminEmployees\/create","methods":["GET","HEAD"]},"AdminEmployees.store":{"uri":"AdminEmployees","methods":["POST"]},"AdminEmployees.show":{"uri":"AdminEmployees\/{AdminEmployee}","methods":["GET","HEAD"]},"AdminEmployees.edit":{"uri":"AdminEmployees\/{AdminEmployee}\/edit","methods":["GET","HEAD"]},"AdminEmployees.update":{"uri":"AdminEmployees\/{AdminEmployee}","methods":["PUT","PATCH"],"bindings":{"employee":"id"}},"AdminEmployees.destroy":{"uri":"AdminEmployees\/{AdminEmployee}","methods":["DELETE"]},"AdminEmployees.search":{"uri":"AdminSearchEmployee","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    for (let name in window.Ziggy.routes) {
        Ziggy.routes[name] = window.Ziggy.routes[name];
    }
}

export { Ziggy };
